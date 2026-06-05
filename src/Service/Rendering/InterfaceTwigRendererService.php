<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Rendering;

use App\Interfacing\Contract\Surface\InterfaceSurfaceRenderableInterface;
use App\Interfacing\Contract\ValueObject\InterfaceShellSlot;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellChromeProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Twig\Environment;

final readonly class InterfaceTwigRendererService implements InterfaceRendererInterface
{
    public function __construct(
        private Environment $twig,
        private InterfaceShellChromeProviderInterface $shellChromeProvider,
        #[Autowire(service: 'profiler')]
        private ?Profiler $profiler = null,
    ) {
    }

    public function render(string $template, array $context = [], int $status = 200): Response
    {
        return $this->renderTwig($template, $context, $status);
    }

    public function renderSurface(InterfaceSurfaceRenderableInterface $surface, array $context = [], int $status = 200): Response
    {
        $template = $surface->templateName();
        if (!$this->twig->getLoader()->exists($template)) {
            throw new \RuntimeException(sprintf('Surface template "%s" was not found for "%s".', $template, $surface::class));
        }

        return $this->renderTwig($template, $context + $surface->toTemplateContext(), $status);
    }

    /**
     * @param array<string, mixed> $context
     */
    private function renderTwig(string $template, array $context, int $status = 200): Response
    {
        $startedAt = hrtime(true);
        if (($context['disableProfiler'] ?? false) && null !== $this->profiler) {
            $this->profiler->disable();
        }

        if (!array_key_exists('shellCompact', $context) && ($context['disableProfiler'] ?? false)) {
            $context['shellCompact'] = true;
        }

        unset($context['disableProfiler']);

        $activeId = isset($context['screenId']) && is_string($context['screenId']) ? $context['screenId'] : null;

        if (!array_key_exists('shell', $context) || null === $context['shell']) {
            $context['shell'] = $this->shellChromeProvider->provide($activeId);
        }

        if (($context['shellCompact'] ?? false) && is_array($context['shell'])) {
            $context['shell']['shellCompact'] = true;
        }

        if (is_array($context['shell'])) {
            $context['shell'] = $this->applyMeaningfulSlotDefaults($context['shell'], $context);
        }

        $response = new Response($this->twig->render($template, $context), $status);
        $response->headers->set('X-Interfacing-Render-ms', number_format((hrtime(true) - $startedAt) / 1_000_000, 2, '.', ''));

        return $response;
    }

    /**
     * @param array<string, mixed> $shell
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    private function applyMeaningfulSlotDefaults(array $shell, array $context): array
    {
        if (isset($shell['locations']) && is_array($shell['locations']) && [] !== $shell['locations']) {
            return $shell;
        }

        $slots = $this->deriveMeaningfulSlots($context);
        if ([] !== $slots) {
            $shell['locations'] = $slots;
        }

        if (!isset($shell['slotMap']) || !is_array($shell['slotMap']) || [] === $shell['slotMap']) {
            $shell['slotMap'] = $this->deriveMeaningfulSlotMap($context);
        }

        return $shell;
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return array<string, list<array<string, mixed>>>
     */
    private function deriveMeaningfulSlots(array $context): array
    {
        $title = $this->stringValue(
            $context['title'] ?? $context['adminProviderPageTitle'] ?? $context['resourceLabel'] ?? $context['workbench']['title'] ?? null,
            'Smart Response',
        );
        $subtitle = $this->stringValue(
            $context['subtitle'] ?? $context['description'] ?? $context['summary'] ?? $context['brandName'] ?? $context['adminProviderResourceLabel'] ?? null,
            '',
        );
        $profileUrl = $this->stringValue(
            $context['profileUrl'] ?? $context['href'] ?? $context['url'] ?? $context['workbench']['profileUrl'] ?? null,
            '',
        );
        $mainUrl = $this->stringValue(
            $context['profileUrl'] ?? $context['href'] ?? $context['url'] ?? $context['workbench']['profileUrl'] ?? $context['workbench']['routeContext']['collectionHref'] ?? null,
            '',
        );
        $resourcePath = $this->stringValue($context['adminProviderResourceName'] ?? $context['resourcePath'] ?? $context['workbench']['routeContext']['resourcePath'] ?? null, '');
        $status = $this->stringValue($context['status'] ?? $context['profileStatus'] ?? $context['vendorStatus'] ?? null, '');
        $publishedAt = $this->stringValue($context['publishedAt'] ?? null, '');
        $coverUrl = $this->stringValue($context['coverUrl'] ?? $context['cover']['url'] ?? null, '');
        $avatarUrl = $this->stringValue($context['avatarUrl'] ?? $context['avatar']['url'] ?? null, '');
        $items = [];

        $profileLabel = '/vendor/' === $profileUrl ? 'Vendor index' : 'My profile';
        $profileDescription = '/vendor/' === $profileUrl ? 'Vendor landing surface' : $title;

        if ('' !== $profileUrl) {
            $items[] = [
                'type' => 'link',
                'label' => '/vendor/' === $profileUrl ? 'Open vendor index' : 'Open',
                'href' => $profileUrl,
                'description' => 'Primary action for the current surface',
            ];
        }

        if ('' !== $resourcePath) {
            $items[] = [
                'type' => 'text',
                'label' => 'Resource',
                'value' => $resourcePath,
            ];
        }

        if ('' !== $status) {
            $items[] = [
                'type' => 'text',
                'label' => 'Status',
                'value' => $status,
            ];
        }

        if ('' !== $publishedAt) {
            $items[] = [
                'type' => 'text',
                'label' => 'Published at',
                'value' => $publishedAt,
            ];
        }

        $locations = [
            InterfaceShellSlot::BODY_TOP => [[
                'type' => 'text',
                'label' => $title,
                'description' => $subtitle,
            ]],
            InterfaceShellSlot::HEADER_LEFT_LOGO => '' !== $avatarUrl ? [[
                'type' => 'media',
                'src' => $avatarUrl,
                'alt' => $title,
                'label' => $title,
                'description' => $subtitle,
            ]] : [],
            InterfaceShellSlot::HEADER_LEFT_NAME => [[
                'type' => 'text',
                'label' => $title,
                'description' => $subtitle,
            ]],
            InterfaceShellSlot::HEADER_LEFT_TITLE => '' !== $subtitle ? [[
                'type' => 'text',
                'label' => $subtitle,
                'description' => $resourcePath,
            ]] : [],
            InterfaceShellSlot::HEADER_CONTEXT => $items,
            InterfaceShellSlot::HEADER_MAIN => '' !== $mainUrl ? [[
                'type' => 'link',
                'label' => 'Open current surface',
                'href' => $mainUrl,
                'description' => $title,
            ]] : [],
            InterfaceShellSlot::HEADER_RIGHT_USER => '' !== $profileUrl ? [[
                'type' => 'link',
                'label' => $profileLabel,
                'href' => $profileUrl,
                'description' => $profileDescription,
            ]] : [],
            InterfaceShellSlot::HEADER_RIGHT_CART => '' !== $avatarUrl || '' !== $coverUrl ? [
                ['type' => 'text', 'label' => 'Avatar', 'value' => '' !== $avatarUrl ? 'available' : 'missing'],
                ['type' => 'text', 'label' => 'Cover', 'value' => '' !== $coverUrl ? 'available' : 'missing'],
            ] : [],
            InterfaceShellSlot::HEADER_RIGHT_NOTIFICATION => [] !== $items ? [[
                'type' => 'text',
                'label' => 'Surface status',
                'value' => $status ?: 'ready',
            ]] : [],
            InterfaceShellSlot::MAIN_TOP => '' !== $coverUrl || '' !== $title ? [[
                'type' => 'media',
                'src' => '' !== $coverUrl ? $coverUrl : ('' !== $avatarUrl ? $avatarUrl : '/mandala.svg'),
                'alt' => $title,
                'label' => $title,
                'description' => $subtitle,
            ]] : [],
            InterfaceShellSlot::MAIN_CONTENT => [[
                'type' => 'text',
                'label' => $title,
                'description' => $subtitle,
            ]],
            InterfaceShellSlot::MAIN_BOTTOM => [] !== $items ? $items : [],
            InterfaceShellSlot::RIGHT_MIDDLE => [] !== $items ? $items : [],
            InterfaceShellSlot::FOOTER_TOP => [[
                'type' => 'text',
                'label' => $title,
                'description' => $subtitle,
            ]],
            InterfaceShellSlot::FOOTER_MAIN => [[
                'type' => 'text',
                'label' => 'Surface',
                'value' => $resourcePath ?: 'interfacing',
            ]],
        ];

        return array_filter($locations, static fn (array $value): bool => [] !== $value);
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return array<string, string>
     */
    private function deriveMeaningfulSlotMap(array $context): array
    {
        $title = $this->stringValue($context['title'] ?? $context['adminProviderPageTitle'] ?? $context['resourceLabel'] ?? null, 'Smart Response');
        $subtitle = $this->stringValue($context['subtitle'] ?? $context['description'] ?? $context['summary'] ?? null, '');

        return array_filter([
            InterfaceShellSlot::BODY_TOP => $title,
            InterfaceShellSlot::HEADER_LEFT_NAME => $title,
            InterfaceShellSlot::HEADER_LEFT_TITLE => $subtitle,
            InterfaceShellSlot::HEADER_CONTEXT => $this->stringValue($context['status'] ?? $context['profileStatus'] ?? $context['vendorStatus'] ?? null, 'Context'),
            InterfaceShellSlot::HEADER_MAIN => 'Current surface',
            InterfaceShellSlot::HEADER_RIGHT_USER => 'User',
            InterfaceShellSlot::MAIN_TOP => 'Main hero',
            InterfaceShellSlot::MAIN_CONTENT => 'Main content',
            InterfaceShellSlot::FOOTER_TOP => $title,
        ], static fn (string $value): bool => '' !== trim($value));
    }

    private function stringValue(mixed $value, string $fallback): string
    {
        if (is_scalar($value) && '' !== trim((string) $value)) {
            return (string) $value;
        }

        return $fallback;
    }
}

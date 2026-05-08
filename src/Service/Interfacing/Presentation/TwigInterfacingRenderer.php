<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Presentation;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Twig\Environment;

final readonly class TwigInterfacingRenderer implements InterfacingRendererInterface
{
    public function __construct(
        private Environment $twig,
        private ShellChromeProviderInterface $shellChromeProvider,
        #[Autowire(service: 'profiler')]
        private ?Profiler $profiler = null,
    ) {
    }

    public function render(string $template, array $context = [], int $status = 200): Response
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

        if (!array_key_exists('shellKnownCrudResources', $context) && is_array($context['shell'])) {
            $context['shellKnownCrudResources'] = $context['shell']['knownCrudResources'] ?? [];
        }

        $response = new Response($this->twig->render($template, $context), $status);
        $response->headers->set('X-Interfacing-Render-ms', number_format((hrtime(true) - $startedAt) / 1_000_000, 2, '.', ''));

        return $response;
    }
}

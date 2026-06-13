<?php

declare(strict_types=1);

namespace App\Interfacing\Integration\Twig;

use App\Interfacing\Service\Location\InterfaceLocationContextService;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class InterfaceLocationTwigExtension extends AbstractExtension
{
    public function __construct(
        private readonly InterfaceLocationContextService $locationContextService,
    ) {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('interface_locations', [$this, 'locations'], ['needs_context' => true]),
            new TwigFunction('interface_location', [$this, 'renderLocation'], [
                'needs_environment' => true,
                'needs_context' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return array<string, list<array<string, mixed>>>
     */
    public function locations(array $context): array
    {
        return $this->locationContextService->locations($context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function renderLocation(Environment $twig, array $context, string $nameEntity): string
    {
        $items = $this->locationContextService->location($context, $nameEntity);

        if ([] === $items) {
            return '';
        }

        return $twig->render('@Interfacing/shell/partial/location_bucket.html.twig', [
            'location' => $nameEntity,
            'items' => $items,
            'provider' => $context['provider'] ?? 'antd-pro',
            'secondaryProvider' => $context['secondaryProvider'] ?? 'primereact',
        ]);
    }
}

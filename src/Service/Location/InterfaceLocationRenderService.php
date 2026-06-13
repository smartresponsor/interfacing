<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Location;

use Twig\Environment;

final readonly class InterfaceLocationRenderService
{
    public function __construct(
        private Environment $twig,
    ) {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function render(array $context, string $locationName): string
    {
        $locations = $this->locations($context);
        $items = \is_array($locations[$locationName] ?? null) ? $locations[$locationName] : [];

        if ([] === $items) {
            return '';
        }

        return $this->twig->render('@Interfacing/shell/partial/location_bucket.html.twig', [
            'location' => $locationName,
            'items' => $items,
        ]);
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    public function locations(array $context): array
    {
        $interface = \is_array($context['interface'] ?? null) ? $context['interface'] : [];

        return \is_array($interface['locations'] ?? null) ? $interface['locations'] : [];
    }
}

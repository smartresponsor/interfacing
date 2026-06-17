<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Location;

use Twig\Environment;

final readonly class InterfaceLocationRenderService
{
    /**
     * Navigation/menu slots must render through provider-native contracts.
     *
     * @var list<string>
     */
    private const PROVIDER_NATIVE_LOCATIONS = [
        'shell.header.right.quick.menu',
        'shell.left.top',
        'shell.left.middle',
        'shell.left.bottom',
        'shell.context.middle',
        'shell.footer.left',
        'shell.footer.context',
        'shell.footer.main',
        'shell.footer.right',
    ];

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

        if ($this->isProviderNativeNavigationLocation($locationName)) {
            return $this->twig->render('@Interfacing/shell/partial/location_bucket.html.twig', [
                'location' => $locationName,
                'items' => $items,
            ]);
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

    private function isProviderNativeNavigationLocation(string $locationName): bool
    {
        return \in_array($locationName, self::PROVIDER_NATIVE_LOCATIONS, true);
    }
}

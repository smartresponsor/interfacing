<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Location;

use App\Interfacing\Registry\Style\InterfaceStyleProviderRegistry;
use Twig\Environment;

final readonly class InterfaceLocationRenderService
{
    public function __construct(
        private Environment $twig,
        private InterfaceLocationContextService $locationContextService,
        private ?InterfaceStyleProviderRegistry $styleProviderRegistry = null,
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

        $variables = [
            'location' => $locationName,
            'items' => $items,
        ];

        if (null !== $this->styleProviderRegistry) {
            $interface = \is_array($context['interface'] ?? null) ? $context['interface'] : [];
            $providerKey = \is_string($interface['style_provider'] ?? null) ? $interface['style_provider'] : 'ant_design';
            $variables['interfaceStyleProvider'] = $this->styleProviderRegistry->get($providerKey)->manifest();
        }

        return $this->twig->render('@Interfacing/shell/partial/location_bucket.html.twig', $variables);
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    public function locations(array $context): array
    {
        if (\is_array($context['shellLocations'] ?? null)) {
            return $context['shellLocations'];
        }

        return $this->locationContextService->locations($context);
    }
}

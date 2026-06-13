<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Location;

/**
 * Normalizes Interfacing render context to the single canonical location shape:
 * interface.locations.
 */
final readonly class InterfaceLocationContextService
{
    /**
     * @param array<string, mixed> $context
     *
     * @return array<string, list<array<string, mixed>>>
     */
    public function locations(array $context): array
    {
        if (!\is_array($context['interface'] ?? null)) {
            return [];
        }

        if (!\is_array($context['interface']['locations'] ?? null)) {
            return [];
        }

        return $this->normalizeLocations($context['interface']['locations']);
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return list<array<string, mixed>>
     */
    public function location(array $context, string $nameEntity): array
    {
        $nameEntity = trim($nameEntity);
        if ('' === $nameEntity) {
            return [];
        }

        return $this->locations($context)[$nameEntity] ?? [];
    }

    /**
     * @param array<mixed> $locations
     *
     * @return array<string, list<array<string, mixed>>>
     */
    private function normalizeLocations(array $locations): array
    {
        $normalized = [];

        foreach ($locations as $nameEntity => $items) {
            if (!\is_string($nameEntity) || '' === trim($nameEntity) || !\is_array($items)) {
                continue;
            }

            $bucket = [];
            foreach ($items as $item) {
                if (\is_array($item)) {
                    $bucket[] = $item;
                }
            }

            if ([] !== $bucket) {
                $normalized[trim($nameEntity)] = $bucket;
            }
        }

        return $normalized;
    }
}

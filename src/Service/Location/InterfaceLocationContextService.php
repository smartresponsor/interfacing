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
            $seen = [];

            foreach ($items as $item) {
                if (!\is_array($item)) {
                    continue;
                }

                $identity = $this->itemIdentity($item);
                if (isset($seen[$identity])) {
                    continue;
                }

                $seen[$identity] = true;
                $bucket[] = $item;
            }

            if ([] !== $bucket) {
                $normalized[trim($nameEntity)] = $bucket;
            }
        }

        return $normalized;
    }

    /** @param array<string, mixed> $item */
    private function itemIdentity(array $item): string
    {
        foreach (['id', 'key'] as $identityKey) {
            if (\is_string($item[$identityKey] ?? null) && '' !== trim($item[$identityKey])) {
                return $identityKey.':'.trim($item[$identityKey]);
            }
        }

        $target = '';
        foreach (['href', 'url', 'path', 'action'] as $targetKey) {
            if (\is_string($item[$targetKey] ?? null) && '' !== trim($item[$targetKey])) {
                $target = trim($item[$targetKey]);
                break;
            }
        }

        $label = '';
        foreach (['label', 'title'] as $labelKey) {
            if (\is_string($item[$labelKey] ?? null) && '' !== trim($item[$labelKey])) {
                $label = trim($item[$labelKey]);
                break;
            }
        }

        return hash('sha256', implode('|', [
            \is_string($item['type'] ?? null) ? trim($item['type']) : '',
            $target,
            $label,
        ]));
    }
}

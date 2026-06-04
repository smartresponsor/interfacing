<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudPreviewPage;
use App\Interfacing\Contract\Crud\InterfaceCrudPreviewRow;
use App\Interfacing\ProviderInterface\Crud\InterfaceCrudWorkbenchPreviewProviderInterface;

/**
 * Standalone fallback preview rows for the generic CRUD workbench.
 *
 * This provider intentionally keeps demo data outside the view builder and
 * returns Interfacing-owned neutral preview DTOs rather than order-specific
 * read models.
 */
final readonly class InterfaceDefaultCrudWorkbenchPreviewProvider implements InterfaceCrudWorkbenchPreviewProviderInterface
{
    public function supports(string $resourcePath): bool
    {
        return true;
    }

    public function provide(string $resourcePath): InterfaceCrudPreviewPage
    {
        $stem = $this->resourceStem($resourcePath);
        $now = new \DateTimeImmutable('2026-05-01T12:00:00+00:00');

        $items = [
            new InterfaceCrudPreviewRow('sample', 'draft', $now->format(DATE_ATOM), 0.00, 'USD', $stem.'-owner@example.test'),
            new InterfaceCrudPreviewRow($stem.'-001', 'active', $now->modify('-1 day')->format(DATE_ATOM), 120.00, 'USD', $stem.'-operator@example.test'),
            new InterfaceCrudPreviewRow($stem.'-002', 'pending', $now->modify('-2 days')->format(DATE_ATOM), 64.50, 'USD', $stem.'-review@example.test'),
        ];

        return new InterfaceCrudPreviewPage($items, count($items), 1, 25);
    }

    private function resourceStem(string $resourcePath): string
    {
        $segments = array_values(array_filter(explode('/', trim($resourcePath, '/')), static fn (string $segment): bool => '' !== $segment));
        $last = $segments[array_key_last($segments)] ?? 'record';

        return preg_replace('/[^a-z0-9-]+/', '-', strtolower($last)) ?: 'record';
    }
}

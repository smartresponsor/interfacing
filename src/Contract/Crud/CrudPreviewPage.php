<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * Neutral preview page for generic CRUD workbench rendering.
 *
 * This contract belongs to Interfacing and intentionally avoids order,
 * billing, or other owning-component vocabulary.
 *
 * @psalm-immutable
 */
final readonly class CrudPreviewPage
{
    /**
     * @param list<CrudPreviewRow> $items
     */
    public function __construct(
        public array $items,
        public int $total,
        public int $page,
        public int $pageSize,
    ) {
    }
}

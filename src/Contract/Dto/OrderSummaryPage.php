<?php

declare(strict_types=1);

namespace App\Contract\Dto;

/**
 * @psalm-immutable
 */
final readonly class OrderSummaryPage
{
    /**
     * @param list<OrderSummaryRow> $items
     */
    public function __construct(
        public array $items,
        public int $total,
        public int $page,
        public int $pageSize,
    ) {
    }
}

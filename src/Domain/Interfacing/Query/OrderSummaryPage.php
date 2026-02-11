<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Query;

/**
 * @psalm-immutable
 */
final class OrderSummaryPage
{
    /**
     * @param list<OrderSummaryRow> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $page,
        public readonly int $pageSize,
    ) {}
}

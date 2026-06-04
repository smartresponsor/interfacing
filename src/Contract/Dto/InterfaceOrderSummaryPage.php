<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Dto;

/**
 * @psalm-immutable
 */
final readonly class InterfaceOrderSummaryPage
{
    /**
     * @param list<InterfaceOrderSummaryRow> $items
     */
    public function __construct(
        public array $items,
        public int $total,
        public int $page,
        public int $pageSize,
    ) {
    }
}

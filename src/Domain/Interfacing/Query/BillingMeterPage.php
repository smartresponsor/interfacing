<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Query;

/**
 * @psalm-immutable
 */
final readonly class BillingMeterPage
{
    /**
     * @param list<BillingMeterRow> $items
     */
    public function __construct(
        public array $items,
        public int   $total,
        public int   $page,
        public int   $pageSize,
    ) {}
}

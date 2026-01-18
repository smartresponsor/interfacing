<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\Domain\Interfacing\Query;

final class OrderSummaryRow
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $createdAtIso,
        public readonly float $totalGross,
        public readonly string $currencyCode,
        public readonly ?string $customerEmail,
    ) {}
}

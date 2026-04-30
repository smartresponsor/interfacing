<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Dto;

final readonly class OrderSummaryRow
{
    public function __construct(
        public string $id,
        public string $status,
        public string $createdAtIso,
        public float $totalGross,
        public string $currencyCode,
        public ?string $customerEmail,
    ) {
    }
}

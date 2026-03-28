<?php

declare(strict_types=1);

namespace App\Contract\Dto;

final readonly class BillingMeterRow
{
    public function __construct(
        public string $id,
        public string $status,
        public float $amount,
        public string $periodFromIso,
        public string $periodToIso,
    ) {
    }
}

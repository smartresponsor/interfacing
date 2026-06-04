<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Dto;

final readonly class InterfaceBillingMeterRow
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

Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Query;

final class BillingMeterRow
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly float $amount,
        public readonly string $periodFromIso,
        public readonly string $periodToIso,
    ) {}
}

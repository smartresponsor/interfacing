Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Query;

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

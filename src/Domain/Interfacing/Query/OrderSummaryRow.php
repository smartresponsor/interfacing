<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Query;

/**
 *
 */

/**
 *
 */
final readonly class OrderSummaryRow
{
    /**
     * @param string $id
     * @param string $status
     * @param string $createdAtIso
     * @param float $totalGross
     * @param string $currencyCode
     * @param string|null $customerEmail
     */
    public function __construct(
        public string  $id,
        public string  $status,
        public string  $createdAtIso,
        public float   $totalGross,
        public string  $currencyCode,
        public ?string $customerEmail,
    ) {}
}

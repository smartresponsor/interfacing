<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Query;

/**
 *
 */

/**
 *
 */
final readonly class BillingMeterRow
{
    /**
     * @param string $id
     * @param string $status
     * @param float $amount
     * @param string $periodFromIso
     * @param string $periodToIso
     */
    public function __construct(
        public string $id,
        public string $status,
        public float  $amount,
        public string $periodFromIso,
        public string $periodToIso,
    ) {}
}

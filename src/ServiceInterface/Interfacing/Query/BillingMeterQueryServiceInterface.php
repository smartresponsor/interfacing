<?php
declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Query;

use App\Domain\Interfacing\Query\BillingMeterPage;

/**
 *
 */

/**
 *
 */
interface BillingMeterQueryServiceInterface
{
    /**
     * @param string $tenantId
     * @param int $page
     * @param int $pageSize
     * @param string|null $status
     * @param string|null $periodFromIso
     * @param string|null $periodToIso
     * @return \App\Domain\Interfacing\Query\BillingMeterPage
     */
    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $periodFromIso,
        ?string $periodToIso,
    ): BillingMeterPage;
}

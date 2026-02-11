<?php
declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Query;

use App\Domain\Interfacing\Query\BillingMeterPage;

interface BillingMeterQueryServiceInterface
{
    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $periodFromIso,
        ?string $periodToIso,
    ): BillingMeterPage;
}

<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Query;

use SmartResponsor\Interfacing\Domain\Interfacing\Query\BillingMeterPage;

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

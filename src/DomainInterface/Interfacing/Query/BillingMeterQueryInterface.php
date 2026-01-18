<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Query;

use SmartResponsor\Interfacing\Domain\Interfacing\Query\BillingMeterPage;

interface BillingMeterQueryInterface
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

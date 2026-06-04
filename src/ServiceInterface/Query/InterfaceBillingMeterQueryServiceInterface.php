<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Query;

use App\Interfacing\Contract\Dto\InterfaceBillingMeterPage;

interface InterfaceBillingMeterQueryServiceInterface
{
    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $periodFromIso,
        ?string $periodToIso,
    ): InterfaceBillingMeterPage;
}

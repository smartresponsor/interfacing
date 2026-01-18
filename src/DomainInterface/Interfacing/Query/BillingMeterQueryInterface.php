Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Query;

use App\Domain\Interfacing\Query\BillingMeterPage;

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

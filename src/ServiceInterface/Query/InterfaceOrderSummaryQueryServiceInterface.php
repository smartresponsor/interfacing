<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Query;

use App\Interfacing\Contract\Dto\InterfaceOrderSummaryPage;

interface InterfaceOrderSummaryQueryServiceInterface
{
    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $createdFromIso,
        ?string $createdToIso,
    ): InterfaceOrderSummaryPage;
}

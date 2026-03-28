<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Query;

use App\Contract\Dto\OrderSummaryPage;

interface OrderSummaryQueryServiceInterface
{
    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $createdFromIso,
        ?string $createdToIso,
    ): OrderSummaryPage;
}

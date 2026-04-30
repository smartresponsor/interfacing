<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Query;

use App\Interfacing\Contract\Dto\OrderSummaryPage;

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

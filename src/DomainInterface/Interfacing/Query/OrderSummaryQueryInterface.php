<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Query;

use App\Domain\Interfacing\Query\OrderSummaryPage;

interface OrderSummaryQueryInterface
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

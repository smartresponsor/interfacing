<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Query;

use SmartResponsor\Interfacing\Domain\Interfacing\Query\OrderSummaryPage;

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

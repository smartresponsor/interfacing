<?php
declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Query;

use App\Domain\Interfacing\Query\OrderSummaryPage;

/**
 *
 */

/**
 *
 */
interface OrderSummaryQueryServiceInterface
{
    /**
     * @param string $tenantId
     * @param int $page
     * @param int $pageSize
     * @param string|null $status
     * @param string|null $createdFromIso
     * @param string|null $createdToIso
     * @return \App\Domain\Interfacing\Query\OrderSummaryPage
     */
    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $createdFromIso,
        ?string $createdToIso,
    ): OrderSummaryPage;
}

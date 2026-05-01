<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceAdminTableRow;

interface EcommerceAdminTableProviderInterface
{
    /** @return list<EcommerceAdminTableRow> */
    public function provide(): array;

    /** @return array<string, list<EcommerceAdminTableRow>> */
    public function groupedByZone(): array;

    /** @return array{connected:int, canonical:int, planned:int, total:int} */
    public function statusCounts(): array;
}

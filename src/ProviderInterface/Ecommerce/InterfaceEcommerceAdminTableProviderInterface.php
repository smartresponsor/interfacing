<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceAdminTableRow;

interface InterfaceEcommerceAdminTableProviderInterface
{
    /** @return list<InterfaceEcommerceAdminTableRow> */
    public function provide(): array;

    /** @return array<string, list<InterfaceEcommerceAdminTableRow>> */
    public function groupedByZone(): array;

    /** @return array{connected:int, canonical:int, planned:int, total:int} */
    public function statusCounts(): array;
}

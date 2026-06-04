<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceComponentSummary;
use App\Interfacing\Contract\View\InterfaceEcommerceScreenEntry;

interface InterfaceEcommerceScreenCatalogProviderInterface
{
    /**
     * @return list<InterfaceEcommerceScreenEntry>
     */
    public function provide(): array;

    /**
     * @return array<string, list<InterfaceEcommerceScreenEntry>>
     */
    public function groupedByZone(): array;

    /**
     * @return array<string, int>
     */
    public function statusCounts(): array;

    /**
     * @return array<string, list<InterfaceEcommerceComponentSummary>>
     */
    public function componentSummaryByZone(): array;
}

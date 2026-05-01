<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceComponentSummary;
use App\Interfacing\Contract\View\EcommerceScreenEntry;

interface EcommerceScreenCatalogProviderInterface
{
    /**
     * @return list<EcommerceScreenEntry>
     */
    public function provide(): array;

    /**
     * @return array<string, list<EcommerceScreenEntry>>
     */
    public function groupedByZone(): array;

    /**
     * @return array<string, int>
     */
    public function statusCounts(): array;

    /**
     * @return array<string, list<EcommerceComponentSummary>>
     */
    public function componentSummaryByZone(): array;
}

<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceComponentRoadmapItem;

interface EcommerceComponentRoadmapProviderInterface
{
    /** @return list<EcommerceComponentRoadmapItem> */
    public function provide(): array;

    /** @return array<string, list<EcommerceComponentRoadmapItem>> */
    public function groupedByZone(): array;

    /** @return array<string, int> */
    public function statusCounts(): array;
}

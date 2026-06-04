<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceComponentRoadmapItem;

interface InterfaceEcommerceComponentRoadmapProviderInterface
{
    /** @return list<InterfaceEcommerceComponentRoadmapItem> */
    public function provide(): array;

    /** @return array<string, list<InterfaceEcommerceComponentRoadmapItem>> */
    public function groupedByZone(): array;

    /** @return array<string, int> */
    public function statusCounts(): array;
}

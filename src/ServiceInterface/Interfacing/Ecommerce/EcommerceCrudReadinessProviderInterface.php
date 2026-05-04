<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceCrudReadinessItem;

interface EcommerceCrudReadinessProviderInterface
{
    /** @return list<EcommerceCrudReadinessItem> */
    public function provide(): array;

    /** @return array<string, list<EcommerceCrudReadinessItem>> */
    public function groupedByZone(): array;

    /** @return array{ready:int, needs_bridge:int, planned:int, total:int} */
    public function gradeCounts(): array;
}

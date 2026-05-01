<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceRuntimeBridgeItem;

interface EcommerceRuntimeBridgeProviderInterface
{
    /** @return list<EcommerceRuntimeBridgeItem> */
    public function provide(): array;

    /** @return array<string, list<EcommerceRuntimeBridgeItem>> */
    public function groupedByZone(): array;

    /** @return array{ready:int, needs_bridge:int, planned:int, total:int} */
    public function gradeCounts(): array;
}

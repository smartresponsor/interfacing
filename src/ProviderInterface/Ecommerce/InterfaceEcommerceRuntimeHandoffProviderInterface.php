<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceRuntimeHandoffItem;

interface InterfaceEcommerceRuntimeHandoffProviderInterface
{
    /** @return list<InterfaceEcommerceRuntimeHandoffItem> */
    public function provide(): array;

    /** @return array<string, list<InterfaceEcommerceRuntimeHandoffItem>> */
    public function groupedByZone(): array;

    /** @return array{ready:int, needs_handoff:int, planned:int, total:int} */
    public function gradeCounts(): array;
}

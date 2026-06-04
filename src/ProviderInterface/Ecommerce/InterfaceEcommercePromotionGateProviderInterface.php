<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommercePromotionGateItem;

interface InterfaceEcommercePromotionGateProviderInterface
{
    /** @return list<InterfaceEcommercePromotionGateItem> */
    public function provide(): array;

    /** @return array<string, list<InterfaceEcommercePromotionGateItem>> */
    public function groupedByZone(): array;

    /** @return array{blocked:int, promote_candidate:int, connected:int, total:int} */
    public function gateCounts(): array;
}

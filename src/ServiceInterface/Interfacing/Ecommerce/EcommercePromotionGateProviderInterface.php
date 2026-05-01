<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommercePromotionGateItem;

interface EcommercePromotionGateProviderInterface
{
    /** @return list<EcommercePromotionGateItem> */
    public function provide(): array;

    /** @return array<string, list<EcommercePromotionGateItem>> */
    public function groupedByZone(): array;

    /** @return array{blocked:int, promote_candidate:int, connected:int, total:int} */
    public function gateCounts(): array;
}

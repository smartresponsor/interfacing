<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceComponentObligationItem;

interface EcommerceComponentObligationProviderInterface
{
    /** @return list<EcommerceComponentObligationItem> */
    public function provide(): array;

    /** @return array<string, list<EcommerceComponentObligationItem>> */
    public function groupedByZone(): array;

    /** @return array{high:int, medium:int, low:int, total:int} */
    public function riskCounts(): array;
}

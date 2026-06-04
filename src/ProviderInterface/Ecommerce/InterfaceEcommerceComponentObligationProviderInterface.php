<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceComponentObligationItem;

interface InterfaceEcommerceComponentObligationProviderInterface
{
    /** @return list<InterfaceEcommerceComponentObligationItem> */
    public function provide(): array;

    /** @return array<string, list<InterfaceEcommerceComponentObligationItem>> */
    public function groupedByZone(): array;

    /** @return array{high:int, medium:int, low:int, total:int} */
    public function riskCounts(): array;
}

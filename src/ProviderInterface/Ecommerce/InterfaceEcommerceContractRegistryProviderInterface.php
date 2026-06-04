<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceContractItem;

interface InterfaceEcommerceContractRegistryProviderInterface
{
    /** @return list<InterfaceEcommerceContractItem> */
    public function provide(): array;

    /** @return array<string, list<InterfaceEcommerceContractItem>> */
    public function groupedByZone(): array;

    /** @return array{formalized:int, draft:int, missing:int, total:int} */
    public function gradeCounts(): array;
}

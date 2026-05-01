<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceContractItem;

interface EcommerceContractRegistryProviderInterface
{
    /** @return list<EcommerceContractItem> */
    public function provide(): array;

    /** @return array<string, list<EcommerceContractItem>> */
    public function groupedByZone(): array;

    /** @return array{formalized:int, draft:int, missing:int, total:int} */
    public function gradeCounts(): array;
}

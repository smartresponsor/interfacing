<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

interface InterfaceEcommerceOperationWorkbenchProviderInterface
{
    /** @return list<object> */
    public function provide(): array;

    /** @return array<string, list<object>> */
    public function groupedByZone(): array;

    /** @return array{connected:int, canonical:int, planned:int, total:int} */
    public function statusCounts(): array;
}

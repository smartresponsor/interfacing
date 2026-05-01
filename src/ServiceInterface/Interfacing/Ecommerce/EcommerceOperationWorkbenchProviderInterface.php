<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

interface EcommerceOperationWorkbenchProviderInterface
{
    /** @return list<object> */
    public function provide(): array;

    /** @return array<string, list<object>> */
    public function groupedByZone(): array;

    /** @return array{connected:int, canonical:int, planned:int, total:int} */
    public function statusCounts(): array;
}

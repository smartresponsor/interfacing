<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceFieldSchemaItem;

interface EcommerceFieldSchemaRegistryProviderInterface
{
    /** @return list<EcommerceFieldSchemaItem> */
    public function provide(): array;

    /** @return array<string, list<EcommerceFieldSchemaItem>> */
    public function groupedByZone(): array;

    /** @return array{schema_ready:int,draft:int,missing:int,total:int} */
    public function gradeCounts(): array;
}

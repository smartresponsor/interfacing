<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceFieldSchemaItem;

interface InterfaceEcommerceFieldSchemaRegistryProviderInterface
{
    /** @return list<InterfaceEcommerceFieldSchemaItem> */
    public function provide(): array;

    /** @return array<string, list<InterfaceEcommerceFieldSchemaItem>> */
    public function groupedByZone(): array;

    /** @return array{schema_ready:int,draft:int,missing:int,total:int} */
    public function gradeCounts(): array;
}

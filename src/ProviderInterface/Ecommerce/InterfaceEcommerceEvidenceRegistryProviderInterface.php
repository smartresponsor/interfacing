<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceEvidenceItem;

interface InterfaceEcommerceEvidenceRegistryProviderInterface
{
    /** @return list<InterfaceEcommerceEvidenceItem> */
    public function provide(): array;

    /** @return array<string, list<InterfaceEcommerceEvidenceItem>> */
    public function groupedByZone(): array;

    /** @return array{complete:int, partial:int, missing:int, total:int} */
    public function gradeCounts(): array;
}

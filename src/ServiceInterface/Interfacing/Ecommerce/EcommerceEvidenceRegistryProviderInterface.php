<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceEvidenceItem;

interface EcommerceEvidenceRegistryProviderInterface
{
    /** @return list<EcommerceEvidenceItem> */
    public function provide(): array;

    /** @return array<string, list<EcommerceEvidenceItem>> */
    public function groupedByZone(): array;

    /** @return array{complete:int, partial:int, missing:int, total:int} */
    public function gradeCounts(): array;
}

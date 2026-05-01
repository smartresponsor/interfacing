<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceCrudFrame;

interface EcommerceCrudFrameProviderInterface
{
    /** @return list<EcommerceCrudFrame> */
    public function provide(): array;

    /** @return array<string, list<EcommerceCrudFrame>> */
    public function groupedByZone(): array;

    /** @return array{connected:int, canonical:int, planned:int, total:int} */
    public function statusCounts(): array;
}

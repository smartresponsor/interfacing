<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Surface;

use App\Interfacing\Contract\View\InterfaceSurfaceAuditItem;

interface InterfaceSurfaceAuditProviderInterface
{
    /**
     * @return list<InterfaceSurfaceAuditItem>
     */
    public function provide(): array;

    /**
     * @return array<string, list<InterfaceSurfaceAuditItem>>
     */
    public function groupedByArea(): array;

    /**
     * @return array<string, int>
     */
    public function statusCounts(): array;
}

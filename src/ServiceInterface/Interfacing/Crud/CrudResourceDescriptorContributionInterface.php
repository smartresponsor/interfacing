<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudResourceDescriptorInterface;

/**
 * Canonical contribution contract for resource metadata used by the generic CRUD bridge.
 *
 * Contributions should publish descriptors only. Interfacing turns descriptors into
 * route-aware link sets after applying route generation and fallback rules.
 */
interface CrudResourceDescriptorContributionInterface
{
    /**
     * @return list<CrudResourceDescriptorInterface>
     */
    public function provide(): array;
}

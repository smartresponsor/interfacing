<?php

declare(strict_types=1);

namespace App\Interfacing\ContributionInterface\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudResourceDescriptorInterface;

/**
 * Canonical contribution contract for resource metadata used by the generic CRUD handoff.
 *
 * Contributions should publish descriptors only. Interfacing turns descriptors into
 * route-aware link sets after applying route generation and fallback rules.
 */
interface InterfaceCrudResourceDescriptorContributionInterface
{
    /**
     * @return list<InterfaceCrudResourceDescriptorInterface>
     */
    public function provide(): array;
}

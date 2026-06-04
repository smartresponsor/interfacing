<?php

declare(strict_types=1);

namespace App\Interfacing\CatalogInterface;

use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;

/**
 * Canonical catalog contract for UI screen specifications consumed by controllers,
 * doctor reports, and view builders.
 *
 * Runtime component-name lookup and registry descriptor catalogs intentionally stay
 * on their own interfaces and must not be collapsed into this contract.
 */
interface InterfaceScreenSpecCatalogInterface
{
    /** @return list<InterfaceScreenSpecInterface> */
    public function all(): array;

    public function get(string $id): InterfaceScreenSpecInterface;
}

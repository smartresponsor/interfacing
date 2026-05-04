<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Catalog;

use App\Interfacing\Contract\View\ScreenSpecInterface;

/**
 * Canonical catalog contract for UI screen specifications consumed by controllers,
 * doctor reports, and view builders.
 *
 * Runtime component-name lookup and registry descriptor catalogs intentionally stay
 * on their own interfaces and must not be collapsed into this contract.
 */
interface ScreenSpecCatalogInterface
{
    /** @return list<ScreenSpecInterface> */
    public function all(): array;

    public function get(string $id): ScreenSpecInterface;
}

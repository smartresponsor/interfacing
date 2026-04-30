<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ServiceInterface\Interfacing\Layout;

use App\Interfacing\Contract\View\LayoutScreenSpecInterface;

interface LayoutCatalogInterface
{
    /** @return array<string, LayoutScreenSpecInterface> */
    public function all(): array;

    /**
     * BC alias for older callers.
     *
     * @return array<string, LayoutScreenSpecInterface>
     */
    public function list(): array;

    public function has(string $layoutKey): bool;

    public function find(string $layoutKey): ?LayoutScreenSpecInterface;

    public function get(string $layoutKey): LayoutScreenSpecInterface;
}

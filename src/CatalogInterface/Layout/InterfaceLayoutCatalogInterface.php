<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\CatalogInterface\Layout;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpecInterface;

interface InterfaceLayoutCatalogInterface
{
    /** @return array<string, InterfaceLayoutScreenSpecInterface> */
    public function all(): array;

    /**
     * BC alias for older callers.
     *
     * @return array<string, InterfaceLayoutScreenSpecInterface>
     */
    public function list(): array;

    public function has(string $layoutKey): bool;

    public function find(string $layoutKey): ?InterfaceLayoutScreenSpecInterface;

    /**
     * BC alias for slug-based callers.
     */
    public function findBySlug(string $slug): ?InterfaceLayoutScreenSpecInterface;

    public function get(string $layoutKey): InterfaceLayoutScreenSpecInterface;
}

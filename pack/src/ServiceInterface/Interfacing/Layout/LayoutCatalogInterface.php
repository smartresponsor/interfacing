<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\ServiceInterface\Interfacing\Layout;

use App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

interface LayoutCatalogInterface
{
    public function hasSlug(string $slug): bool;

    public function getBySlug(string $slug): LayoutScreenSpecInterface;

    /**
     * @return list<LayoutScreenSpecInterface>
     */
    public function all(): array;
}

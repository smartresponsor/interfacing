<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

/**
 *
 */

/**
 *
 */
interface LayoutCatalogInterface
{
    /**
     * @param string $slug
     * @return bool
     */
    public function hasSlug(string $slug): bool;

    /**
     * @param string $slug
     * @return \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface
     */
    public function getBySlug(string $slug): LayoutScreenSpecInterface;

    /**
     * @return list<LayoutScreenSpecInterface>
     */
    public function all(): array;
}

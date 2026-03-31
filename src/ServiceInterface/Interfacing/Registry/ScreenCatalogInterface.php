<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\ServiceInterface\Interfacing\Registry;

/**
 *
 */

/**
 *
 */
interface ScreenCatalogInterface
{
    /**
     * @return list<ScreenDescriptorInterface>
     */
    public function all(): array;

    /**
     * @param string $screenId
     * @return \App\ServiceInterface\Interfacing\Registry\ScreenDescriptorInterface
     */
    public function get(string $screenId): ScreenDescriptorInterface;
}

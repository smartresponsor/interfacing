<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing;

/**
 *
 */

/**
 *
 */
interface BaseContextProviderInterface
{
    /** @return array<string,mixed> */
    public function provide(): array;
}

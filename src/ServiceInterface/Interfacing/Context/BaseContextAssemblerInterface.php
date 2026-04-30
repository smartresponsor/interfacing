<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ServiceInterface\Interfacing\Context;

/**
 *
 */

/**
 *
 */
interface BaseContextAssemblerInterface
{
    /** @return array<string, mixed> */
    public function assemble(): array;
}

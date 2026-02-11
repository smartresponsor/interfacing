<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\DomainInterface\Interfacing\Action;

interface ActionResultInterface
{
    public function kind(): string;
    /** @return array<int, mixed> */
    public function payload(): array;
}


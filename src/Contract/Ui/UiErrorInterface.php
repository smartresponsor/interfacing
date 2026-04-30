<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Contract\Ui;

interface UiErrorInterface
{
    public function scope(): string;

    public function path(): ?string;

    public function text(): string;

    public function code(): ?string;
}

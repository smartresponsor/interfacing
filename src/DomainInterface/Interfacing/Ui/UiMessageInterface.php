<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\DomainInterface\Interfacing\Ui;

interface UiMessageInterface
{
    public function type(): string;
    public function text(): string;
    public function code(): ?string;
}


<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\DescriptorInterface\AttributeRegistry;

interface InterfaceScreenDescriptorInterface
{
    public function screenId(): string;

    public function title(): string;

    public function navGroup(): ?string;

    public function navOrder(): int;

    public function isVisible(): bool;
}

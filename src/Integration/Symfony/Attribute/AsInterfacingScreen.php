<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Integration\Symfony\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class AsInterfacingScreen
{
    public function __construct(
        public string $id,
        public string $title,
        public ?string $navGroup = null,
        public ?string $navIcon = null,
        public int $navOrder = 0,
        public bool $isVisible = true,
    ) {
    }
}

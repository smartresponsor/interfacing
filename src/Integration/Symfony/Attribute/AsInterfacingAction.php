<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Integration\Symfony\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class AsInterfacingAction
{
    public function __construct(
        public string $screenId,
        public string $id,
        public string $title,
        public int $order = 0,
    ) {
    }
}

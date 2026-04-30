<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Contract\Spec;

final readonly class MetricSpec
{
    public function __construct(
        public string $id,
        public string $title,
        public string $value,
        public ?string $hint = null,
    ) {
    }
}

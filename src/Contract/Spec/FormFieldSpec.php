<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Contract\Spec;

    final readonly class FormFieldSpec
{
    /**
     * @param array<string, scalar|null> $option
     */
    public function __construct(
        public string $name,
        public string $type,
        public string $label,
        public bool $required = false,
        public ?string $placeholder = null,
        public array $option = [],
    ) {
    }
}

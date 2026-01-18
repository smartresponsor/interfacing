<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\Domain\Interfacing\Spec;

    final class FormFieldSpec
{
    /**
     * @param array<string, scalar|null> $option
     */
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $label,
        public readonly bool $required = false,
        public readonly ?string $placeholder = null,
        public readonly array $option = [],
    ) {
    }
}


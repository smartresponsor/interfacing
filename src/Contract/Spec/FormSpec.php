<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Contract\Spec;

    final readonly class FormSpec
{
    /** @var list<FormFieldSpec> */
    public array $field;

    /**
     * @param list<FormFieldSpec> $field
     */
    public function __construct(
        public string $id,
        array $field,
    ) {
        $this->field = $field;
    }
}

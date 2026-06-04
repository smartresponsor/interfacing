<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Contract\Spec;

final readonly class InterfaceFormSpec
{
    /** @var list<InterfaceFormFieldSpec> */
    public array $field;

    /**
     * @param list<InterfaceFormFieldSpec> $field
     */
    public function __construct(
        public string $id,
        array $field,
    ) {
        $this->field = $field;
    }
}

<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\Domain\Interfacing\Spec;

    final class FormSpec
{
    /** @var list<FormFieldSpec> */
    public readonly array $field;

    /**
     * @param list<FormFieldSpec> $field
     */
    public function __construct(
        public readonly string $id,
        array $field,
    ) {
        $this->field = $field;
    }
}


<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

final class InterfaceFormSpec
{
    /**
     * @param list<InterfaceFormFieldSpec> $field
     */
    public function __construct(
        private string $id,
        private readonly string $title,
        private readonly array $field,
        private string $submitLabel = 'Submit',
        private string $hint = '',
    ) {
        $this->id = trim($this->id);
        if ('' === $this->id) {
            throw new \InvalidArgumentException('InterfaceFormSpec id must be non-empty.');
        }
        if ([] === $this->field) {
            throw new \InvalidArgumentException('InterfaceFormSpec field must be non-empty.');
        }
        $this->submitLabel = '' !== trim($this->submitLabel) ? trim($this->submitLabel) : 'Submit';
        $this->hint = trim($this->hint);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    /** @return list<InterfaceFormFieldSpec> */
    public function field(): array
    {
        return $this->field;
    }

    public function submitLabel(): string
    {
        return $this->submitLabel;
    }

    public function hint(): string
    {
        return $this->hint;
    }
}

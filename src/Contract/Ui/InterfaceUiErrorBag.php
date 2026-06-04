<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\Ui;

final class InterfaceUiErrorBag
{
    /** @var InterfaceUiError[] */
    private array $global = [];

    /** @var array<string, InterfaceUiError[]> */
    private array $field = [];

    public function addGlobal(InterfaceUiError $error): void
    {
        $this->global[] = $error;
    }

    public function addField(string $field, InterfaceUiError $error): void
    {
        $this->field[$field] ??= [];
        $this->field[$field][] = $error;
    }

    public function hasAny(): bool
    {
        return [] !== $this->global || [] !== $this->field;
    }

    /** @return InterfaceUiError[] */
    public function global(): array
    {
        return $this->global;
    }

    /** @return array<string, InterfaceUiError[]> */
    public function field(): array
    {
        return $this->field;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $field = [];
        foreach ($this->field as $k => $errors) {
            $field[$k] = array_map(static fn (InterfaceUiError $e) => $e->toArray(), $errors);
        }

        return [
            'global' => array_map(static fn (InterfaceUiError $e) => $e->toArray(), $this->global),
            'field' => $field,
        ];
    }
}

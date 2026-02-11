<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Ui;

/**
 *
 */

/**
 *
 */
final class UiErrorBag
{
    /** @var UiError[] */
    private array $global = [];

    /** @var array<string, UiError[]> */
    private array $field = [];

    /**
     * @param \App\Domain\Interfacing\Ui\UiError $error
     * @return void
     */
    public function addGlobal(UiError $error): void
    {
        $this->global[] = $error;
    }

    /**
     * @param string $field
     * @param \App\Domain\Interfacing\Ui\UiError $error
     * @return void
     */
    public function addField(string $field, UiError $error): void
    {
        $this->field[$field] ??= [];
        $this->field[$field][] = $error;
    }

    /**
     * @return bool
     */
    public function hasAny(): bool
    {
        return $this->global !== [] || $this->field !== [];
    }

    /** @return UiError[] */
    public function global(): array
    {
        return $this->global;
    }

    /** @return array<string, UiError[]> */
    public function field(): array
    {
        return $this->field;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $field = [];
        foreach ($this->field as $k => $errors) {
            $field[$k] = array_map(static fn (UiError $e) => $e->toArray(), $errors);
        }

        return [
            'global' => array_map(static fn (UiError $e) => $e->toArray(), $this->global),
            'field' => $field,
        ];
    }
}

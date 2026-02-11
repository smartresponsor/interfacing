<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

/**
 *
 */

/**
 *
 */
final class UiErrorBag
{
    /** @var list<UiError> */
    private array $error = [];

    /**
     * @param \App\Domain\Interfacing\Model\UiError $error
     * @return void
     */
    public function add(UiError $error): void
    {
        $this->error[] = $error;
    }

    /** @return list<UiError> */
    public function all(): array
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->error === [];
    }
}

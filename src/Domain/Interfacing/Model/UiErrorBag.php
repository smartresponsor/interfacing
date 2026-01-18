<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Domain\Interfacing\Model;

final class UiErrorBag
{
    /** @var list<UiError> */
    private array $error = [];

    public function add(UiError $error): void
    {
        $this->error[] = $error;
    }

    /** @return list<UiError> */
    public function all(): array
    {
        return $this->error;
    }

    public function isEmpty(): bool
    {
        return $this->error === [];
    }
}

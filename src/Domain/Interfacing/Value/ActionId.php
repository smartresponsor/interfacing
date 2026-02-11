<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Value;

final class ActionId
{
    private string $value;

    private function __construct(string $value)
    {
        if ($value === '' || !preg_match('/^[a-z0-9\-.]+$/', $value)) {
            throw new \InvalidArgumentException('Invalid actionId.');
        }
        $this->value = $value;
    }

    public static function of(string $value): self
    {
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }
}

<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Contract\ValueObject;

final class WidgetId implements WidgetIdInterface
{
    private function __construct(private readonly string $value)
    {
    }

    public static function fromString(string $value): self
    {
        $value = trim($value);
        if ('' === $value) {
            throw new \InvalidArgumentException('WidgetId must be non-empty.');
        }

        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }
}

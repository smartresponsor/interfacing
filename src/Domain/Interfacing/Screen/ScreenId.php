<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Domain\Interfacing\Screen;

final class ScreenId
{
    public function __construct(private readonly string $value)
    {
        $v = trim($this->value);
        if ($v === '' || !preg_match('/^[a-z0-9][a-z0-9\-\.]{1,127}$/', $v)) {
            throw new \InvalidArgumentException('Invalid screen id.');
        }
        $this->value = $v;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(ScreenId $other): bool
    {
        return $this->value === $other->value;
    }
}

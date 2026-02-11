<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Domain\Interfacing\Screen;

/**
 *
 */

/**
 *
 */
final readonly class ScreenId
{
    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        $v = trim($this->value);
        if ($v === '' || !preg_match('/^[a-z0-9][a-z0-9\-\.]{1,127}$/', $v)) {
            throw new \InvalidArgumentException('Invalid screen id.');
        }
        $this->value = $v;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param \App\Domain\Interfacing\Screen\ScreenId $other
     * @return bool
     */
    public function equals(ScreenId $other): bool
    {
        return $this->value === $other->value;
    }
}

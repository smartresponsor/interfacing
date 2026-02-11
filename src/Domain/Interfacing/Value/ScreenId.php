<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Value;

/**
 *
 */

/**
 *
 */
final class ScreenId
{
    private string $value;

    /**
     * @param string $value
     */
    private function __construct(string $value)
    {
        if ($value === '' || !preg_match('/^[a-z0-9\-]+$/', $value)) {
            throw new \InvalidArgumentException('Invalid screenId.');
        }
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return self
     */
    public static function of(string $value): self
    {
        return new self($value);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }
}

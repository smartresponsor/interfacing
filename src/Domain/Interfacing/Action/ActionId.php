<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Domain\Interfacing\Action;

/**
 *
 */

/**
 *
 */
final readonly class ActionId
{
    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        $v = trim($this->value);
        if ($v === '' || !preg_match('/^[a-z0-9][a-z0-9\-\.]{1,127}$/', $v)) {
            throw new \InvalidArgumentException('Invalid action id.');
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
}

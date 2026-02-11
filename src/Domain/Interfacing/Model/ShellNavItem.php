<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

use App\Domain\Interfacing\Value\ScreenId;

/**
 *
 */

/**
 *
 */
final class ShellNavItem
{
    /**
     * @param \App\Domain\Interfacing\Value\ScreenId $screenId
     * @param string $label
     */
    public function __construct(private readonly ScreenId $screenId, private readonly string $label)
    {
        if ($label === '') {
            throw new \InvalidArgumentException('Nav label must not be empty.');
        }
    }

    /**
     * @return \App\Domain\Interfacing\Value\ScreenId
     */
    public function screenId(): ScreenId { return $this->screenId; }

    /**
     * @return string
     */
    public function label(): string { return $this->label; }
}

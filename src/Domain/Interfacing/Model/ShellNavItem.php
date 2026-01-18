<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Domain\Interfacing\Model;

use SmartResponsor\Interfacing\Domain\Interfacing\Value\ScreenId;

final class ShellNavItem
{
    public function __construct(private ScreenId $screenId, private string $label)
    {
        if ($label === '') {
            throw new \InvalidArgumentException('Nav label must not be empty.');
        }
    }

    public function screenId(): ScreenId { return $this->screenId; }
    public function label(): string { return $this->label; }
}

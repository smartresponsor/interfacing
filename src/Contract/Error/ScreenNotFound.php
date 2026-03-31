<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Contract\Error;

final class ScreenNotFound extends \RuntimeException
{
    public static function forLayoutId(string $layoutId): self
    {
        return new self('Unknown interfacing screen: '.$layoutId);
    }
}

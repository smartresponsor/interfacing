<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Contract\Error;

final class ScreenForbidden extends \RuntimeException
{
    public static function forLayoutId(string $layoutId): self
    {
        return new self('Access denied for screen: '.$layoutId);
    }
}

<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Domain\Interfacing\Error;

/**
 *
 */

/**
 *
 */
final class ScreenForbidden extends \RuntimeException
{
    /**
     * @param string $layoutId
     * @return self
     */
    public static function forLayoutId(string $layoutId): self
    {
        return new self('Access denied for screen: '.$layoutId);
    }
}

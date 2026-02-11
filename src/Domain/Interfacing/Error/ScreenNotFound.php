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
final class ScreenNotFound extends \RuntimeException
{
    /**
     * @param string $layoutId
     * @return self
     */
    public static function forLayoutId(string $layoutId): self
    {
        return new self('Unknown interfacing screen: '.$layoutId);
    }
}

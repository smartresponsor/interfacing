<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Domain\Interfacing\Layout;

final class LayoutSlot
{
    public const HEADER = 'header';
    public const NAV = 'nav';
    public const MAIN = 'main';
    public const ASIDE = 'aside';
    public const FOOTER = 'footer';

    /** @return string[] */
    public static function all(): array
    {
        return [self::HEADER, self::NAV, self::MAIN, self::ASIDE, self::FOOTER];
    }

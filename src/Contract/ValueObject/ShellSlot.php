<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\ValueObject;

final class ShellSlot
{
    public const TOPBAR_LEFT = 'shell.topbar.left';
    public const TOPBAR_RIGHT = 'shell.topbar.right';
    public const NAV_PRIMARY = 'shell.nav.primary';
    public const NAV_SECTION = 'shell.nav.section';
    public const CONTENT_HEADER = 'shell.content.header';
    public const CONTENT_BODY = 'shell.content.body';
    public const CONTENT_ASIDE = 'shell.content.aside';
    public const FOOTER_PRIMARY = 'shell.footer.primary';
    public const FOOTER_SECONDARY = 'shell.footer.secondary';

    /** @return list<string> */
    public static function all(): array
    {
        return [
            self::TOPBAR_LEFT,
            self::TOPBAR_RIGHT,
            self::NAV_PRIMARY,
            self::NAV_SECTION,
            self::CONTENT_HEADER,
            self::CONTENT_BODY,
            self::CONTENT_ASIDE,
            self::FOOTER_PRIMARY,
            self::FOOTER_SECONDARY,
        ];
    }

    /** @return array<string,string> */
    public static function labelMap(): array
    {
        return [
            self::TOPBAR_LEFT => 'Top bar left',
            self::TOPBAR_RIGHT => 'Top bar right',
            self::NAV_PRIMARY => 'Primary navigation',
            self::NAV_SECTION => 'Section navigation',
            self::CONTENT_HEADER => 'Content header',
            self::CONTENT_BODY => 'Content body',
            self::CONTENT_ASIDE => 'Content aside',
            self::FOOTER_PRIMARY => 'Footer primary',
            self::FOOTER_SECONDARY => 'Footer secondary',
        ];
    }
}

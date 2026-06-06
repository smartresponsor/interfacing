<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\ValueObject;

final class InterfaceShellSlot
{
    public const BODY_TOP = 'shell.body.top';

    public const LEFT_TOP = 'shell.left.top';
    public const LEFT_MIDDLE = 'shell.left.middle';
    public const LEFT_BOTTOM = 'shell.left.bottom';

    public const CONTEXT_TOP = 'shell.context.top';
    public const CONTEXT_MIDDLE = 'shell.context.middle';
    public const CONTEXT_BOTTOM = 'shell.context.bottom';

    public const MAIN_TOP = 'shell.main.top';
    public const MAIN_TOOLBAR = 'shell.main.toolbar';
    public const MAIN_CONTENT = 'shell.main.content';
    public const MAIN_BOTTOM = 'shell.main.bottom';

    public const RIGHT_TOP = 'shell.right.top';
    public const RIGHT_TOOL = 'shell.right.tool';
    public const RIGHT_FILTER = 'shell.right.filter';
    public const RIGHT_MIDDLE = 'shell.right.middle';
    public const RIGHT_BOTTOM = 'shell.right.bottom';

    public const FOOTER_TOP = 'shell.footer.top';
    public const FOOTER_LEFT = 'shell.footer.left';
    public const FOOTER_CONTEXT = 'shell.footer.context';
    public const FOOTER_MAIN = 'shell.footer.main';
    public const FOOTER_RIGHT = 'shell.footer.right';

    public const HEADER_BOTTOM = 'shell.header.bottom';

    public const NAV_PRIMARY = self::LEFT_MIDDLE;
    public const NAV_SECTION = self::CONTEXT_MIDDLE;
    public const CONTENT_HEADER = self::MAIN_TOP;
    public const CONTENT_TOOLBAR = self::MAIN_TOOLBAR;
    public const CONTENT_BODY = self::MAIN_CONTENT;
    public const CONTENT_ASIDE = self::RIGHT_MIDDLE;
    public const FOOTER_PRIMARY = self::FOOTER_LEFT;
    public const FOOTER_SECONDARY = self::FOOTER_CONTEXT;

    /** @return list<string> */
    public static function all(): array
    {
        return [
            self::BODY_TOP,
            self::LEFT_TOP,
            self::LEFT_MIDDLE,
            self::LEFT_BOTTOM,
            self::CONTEXT_TOP,
            self::CONTEXT_MIDDLE,
            self::CONTEXT_BOTTOM,
            self::MAIN_TOP,
            self::MAIN_TOOLBAR,
            self::MAIN_CONTENT,
            self::MAIN_BOTTOM,
            self::RIGHT_TOP,
            self::RIGHT_TOOL,
            self::RIGHT_FILTER,
            self::RIGHT_MIDDLE,
            self::RIGHT_BOTTOM,
            self::FOOTER_TOP,
            self::FOOTER_LEFT,
            self::FOOTER_CONTEXT,
            self::FOOTER_MAIN,
            self::FOOTER_RIGHT,
            self::HEADER_BOTTOM,
        ];
    }

    /** @return array<string,string> */
    public static function labelMap(): array
    {
        return [
            self::BODY_TOP => 'Body top',
            self::LEFT_TOP => 'Left top',
            self::LEFT_MIDDLE => 'Left middle',
            self::LEFT_BOTTOM => 'Left bottom',
            self::CONTEXT_TOP => 'Context top',
            self::CONTEXT_MIDDLE => 'Context middle',
            self::CONTEXT_BOTTOM => 'Context bottom',
            self::MAIN_TOP => 'Main top',
            self::MAIN_TOOLBAR => 'Main toolbar',
            self::MAIN_CONTENT => 'Main content',
            self::MAIN_BOTTOM => 'Main bottom',
            self::RIGHT_TOP => 'Right top',
            self::RIGHT_TOOL => 'Right tool',
            self::RIGHT_FILTER => 'Right filter',
            self::RIGHT_MIDDLE => 'Right middle',
            self::RIGHT_BOTTOM => 'Right bottom',
            self::FOOTER_TOP => 'Footer top',
            self::FOOTER_LEFT => 'Footer left',
            self::FOOTER_CONTEXT => 'Footer context',
            self::FOOTER_MAIN => 'Footer main',
            self::FOOTER_RIGHT => 'Footer right',
            self::HEADER_BOTTOM => 'Header bottom',
        ];
    }
}

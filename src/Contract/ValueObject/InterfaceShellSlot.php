<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\ValueObject;

final class InterfaceShellSlot
{
    public const BODY_TOP = 'shell.body.top';

    public const HEADER_LEFT = 'shell.header.left';
    public const HEADER_LEFT_LOGO = 'shell.header.left.logo';
    public const HEADER_LEFT_NAME = 'shell.header.left.name';
    public const HEADER_LEFT_TITLE = 'shell.header.left.title';
    public const HEADER_CONTEXT = 'shell.header.context';
    public const HEADER_MAIN = 'shell.header.main';
    public const HEADER_RIGHT = 'shell.header.right';
    public const HEADER_RIGHT_USER = 'shell.header.right.user';
    public const HEADER_RIGHT_CART = 'shell.header.right.cart';
    public const HEADER_RIGHT_NOTIFICATION = 'shell.header.right.notification';
    public const HEADER_RIGHT_TOGGLE = 'shell.header.right.toggle';
    public const HEADER_BOTTOM = 'shell.header.bottom';

    public const LEFT_TOP = 'shell.left.top';
    public const LEFT_MIDDLE = 'shell.left.middle';
    public const LEFT_BOTTOM = 'shell.left.bottom';

    public const CONTEXT_TOP = 'shell.context.top';
    public const CONTEXT_MIDDLE = 'shell.context.middle';
    public const CONTEXT_BOTTOM = 'shell.context.bottom';

    public const MAIN_TOP = 'shell.main.top';
    public const MAIN_CONTENT = 'shell.main.content';
    public const MAIN_BOTTOM = 'shell.main.bottom';

    public const RIGHT_TOP = 'shell.right.top';
    public const RIGHT_MIDDLE = 'shell.right.middle';
    public const RIGHT_BOTTOM = 'shell.right.bottom';

    public const FOOTER_TOP = 'shell.footer.top';
    public const FOOTER_LEFT = 'shell.footer.left';
    public const FOOTER_CONTEXT = 'shell.footer.context';
    public const FOOTER_MAIN = 'shell.footer.main';
    public const FOOTER_RIGHT = 'shell.footer.right';

    public const TOPBAR_LEFT = self::HEADER_LEFT;
    public const TOPBAR_RIGHT = self::HEADER_RIGHT;
    public const NAV_PRIMARY = self::LEFT_MIDDLE;
    public const NAV_SECTION = self::CONTEXT_MIDDLE;
    public const CONTENT_HEADER = self::MAIN_TOP;
    public const CONTENT_BODY = self::MAIN_CONTENT;
    public const CONTENT_ASIDE = self::RIGHT_MIDDLE;
    public const FOOTER_PRIMARY = self::FOOTER_LEFT;
    public const FOOTER_SECONDARY = self::FOOTER_CONTEXT;

    /** @return list<string> */
    public static function all(): array
    {
        return [
            self::BODY_TOP,
            self::HEADER_LEFT,
            self::HEADER_LEFT_LOGO,
            self::HEADER_LEFT_NAME,
            self::HEADER_LEFT_TITLE,
            self::HEADER_CONTEXT,
            self::HEADER_MAIN,
            self::HEADER_RIGHT,
            self::HEADER_RIGHT_USER,
            self::HEADER_RIGHT_CART,
            self::HEADER_RIGHT_NOTIFICATION,
            self::HEADER_RIGHT_TOGGLE,
            self::HEADER_BOTTOM,
            self::LEFT_TOP,
            self::LEFT_MIDDLE,
            self::LEFT_BOTTOM,
            self::CONTEXT_TOP,
            self::CONTEXT_MIDDLE,
            self::CONTEXT_BOTTOM,
            self::MAIN_TOP,
            self::MAIN_CONTENT,
            self::MAIN_BOTTOM,
            self::RIGHT_TOP,
            self::RIGHT_MIDDLE,
            self::RIGHT_BOTTOM,
            self::FOOTER_TOP,
            self::FOOTER_LEFT,
            self::FOOTER_CONTEXT,
            self::FOOTER_MAIN,
            self::FOOTER_RIGHT,
        ];
    }

    /** @return array<string,string> */
    public static function labelMap(): array
    {
        return [
            self::BODY_TOP => 'Body top',
            self::HEADER_LEFT => 'Header left',
            self::HEADER_LEFT_LOGO => 'Header logo',
            self::HEADER_LEFT_NAME => 'Header name',
            self::HEADER_LEFT_TITLE => 'Header title',
            self::HEADER_CONTEXT => 'Header context',
            self::HEADER_MAIN => 'Header main',
            self::HEADER_RIGHT => 'Header right',
            self::HEADER_RIGHT_USER => 'Header user',
            self::HEADER_RIGHT_CART => 'Header cart',
            self::HEADER_RIGHT_NOTIFICATION => 'Header notification',
            self::HEADER_RIGHT_TOGGLE => 'Header toggle',
            self::HEADER_BOTTOM => 'Header bottom',
            self::LEFT_TOP => 'Left top',
            self::LEFT_MIDDLE => 'Left middle',
            self::LEFT_BOTTOM => 'Left bottom',
            self::CONTEXT_TOP => 'Context top',
            self::CONTEXT_MIDDLE => 'Context middle',
            self::CONTEXT_BOTTOM => 'Context bottom',
            self::MAIN_TOP => 'Main top',
            self::MAIN_CONTENT => 'Main content',
            self::MAIN_BOTTOM => 'Main bottom',
            self::RIGHT_TOP => 'Right top',
            self::RIGHT_MIDDLE => 'Right middle',
            self::RIGHT_BOTTOM => 'Right bottom',
            self::FOOTER_TOP => 'Footer top',
            self::FOOTER_LEFT => 'Footer left',
            self::FOOTER_CONTEXT => 'Footer context',
            self::FOOTER_MAIN => 'Footer main',
            self::FOOTER_RIGHT => 'Footer right',
        ];
    }
}

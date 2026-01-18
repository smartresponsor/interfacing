<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Service\Interfacing;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ShellNavGroup;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\ShellNavItem;
use SmartResponsor\Interfacing\Domain\Interfacing\Value\ScreenId;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\ShellNavProviderInterface;

final class ShellNavProvider implements ShellNavProviderInterface
{
    public function provide(): array
    {
        return [
            new ShellNavGroup('Interfacing', [
                new ShellNavItem(ScreenId::of('interfacing-doctor'), 'Doctor'),
            ]),
            new ShellNavGroup('Component', [
                new ShellNavItem(ScreenId::of('category-admin'), 'Category Admin'),
            ]),
        ];
    }
}

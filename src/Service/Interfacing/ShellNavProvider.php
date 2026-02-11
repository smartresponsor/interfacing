<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing;

use App\Domain\Interfacing\Model\ShellNavGroup;
use App\Domain\Interfacing\Model\ShellNavItem;
use App\Domain\Interfacing\Value\ScreenId;
use App\ServiceInterface\Interfacing\ShellNavProviderInterface;

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

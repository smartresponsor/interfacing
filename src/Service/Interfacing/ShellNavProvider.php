<?php

declare(strict_types=1);

namespace App\Service\Interfacing;

use App\Contract\View\ShellNavGroup;
use App\Contract\View\ShellNavItem;
use App\ServiceInterface\Interfacing\ShellNavProviderInterface;

final class ShellNavProvider implements ShellNavProviderInterface
{
    public function provide(): array
    {
        return [
            new ShellNavGroup('interfacing', 'Interfacing', [
                new ShellNavItem('interfacing-doctor', 'Doctor', '/interfacing/screen/interfacing-doctor', 'interfacing'),
            ]),
            new ShellNavGroup('component', 'Component', [
                new ShellNavItem('category-admin', 'Category Admin', '/interfacing/screen/category-admin', 'component'),
            ]),
        ];
    }
}

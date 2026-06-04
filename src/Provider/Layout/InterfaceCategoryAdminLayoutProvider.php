<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Layout;

use App\Interfacing\Contract\ValueObject\InterfaceScreenId;
use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\ProviderInterface\Layout\InterfaceLayoutProviderInterface;

final class InterfaceCategoryAdminLayoutProvider implements InterfaceLayoutProviderInterface
{
    public function id(): string
    {
        return 'category-admin';
    }

    public function provide(): array
    {
        return [
            new InterfaceLayoutScreenSpec(
                block: [],
                id: 'category-admin',
                title: 'Category Admin',
                navGroup: 'catalog',
                screenId: InterfaceScreenId::fromString('category-admin'),
                routePath: 'category-admin',
                navOrder: 60,
            ),
        ];
    }
}

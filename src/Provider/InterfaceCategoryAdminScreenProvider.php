<?php

declare(strict_types=1);

namespace App\Interfacing\Provider;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\Contract\View\InterfaceScreenSpec;
use App\Interfacing\ProviderInterface\InterfaceScreenProviderInterface;

final class InterfaceCategoryAdminScreenProvider implements InterfaceScreenProviderInterface
{
    public function provide(): array
    {
        return [
            new InterfaceScreenSpec(
                'category-admin',
                'Category Admin',
                new InterfaceLayoutScreenSpec(id: 'category-admin-layout', title: 'Category Admin', routePath: 'category/admin'),
                [],
                ['ROLE_ADMIN'],
                'Remote admin for Category component (list, filter, edit).',
                'category/admin',
            ),
        ];
    }
}

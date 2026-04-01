<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Provider;

use App\Contract\View\LayoutScreenSpec;
use App\Contract\View\ScreenSpec;
use App\ServiceInterface\Interfacing\ScreenProviderInterface;

final class CategoryAdminScreenProvider implements ScreenProviderInterface
{
    public function provide(): array
    {
        return [
            new ScreenSpec(
                'category-admin',
                'Category Admin',
                new LayoutScreenSpec(id: 'category-admin-layout', title: 'Category Admin', routePath: 'interfacing/category/admin'),
                [],
                ['ROLE_ADMIN'],
                'Remote admin for Category component (list, filter, edit).',
                'interfacing/category/admin',
            ),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Layout\Provider;

use App\Interfacing\Contract\ValueObject\ScreenId;
use App\Interfacing\Contract\View\LayoutScreenSpec;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;

final class CategoryAdminLayoutProvider implements LayoutProviderInterface
{
    public function id(): string
    {
        return 'category-admin';
    }

    public function provide(): array
    {
        return [
            new LayoutScreenSpec(
                block: [],
                id: 'category-admin',
                title: 'Category Admin',
                navGroup: 'catalog',
                screenId: ScreenId::fromString('category-admin'),
                routePath: 'interfacing/category-admin',
                navOrder: 60,
            ),
        ];
    }
}

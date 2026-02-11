<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Provider;

use App\Domain\Interfacing\Model\AccessRule;
use App\Domain\Interfacing\Model\ScreenSpec;
use App\Domain\Interfacing\Value\ScreenId;
use App\ServiceInterface\Interfacing\ScreenProviderInterface;

final class CategoryAdminScreenProvider implements ScreenProviderInterface
{
    public function provide(): array
    {
        return [
            new ScreenSpec(
                ScreenId::of('category-admin'),
                'Category Admin',
                'Remote admin for Category component (list, filter, edit).',
                'interfacing/category/admin',
                AccessRule::requireRole(['ROLE_ADMIN'])
            ),
        ];
    }
}

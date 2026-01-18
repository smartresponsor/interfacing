<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Service\Interfacing\Provider;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\AccessRule;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\ScreenSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Value\ScreenId;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\ScreenProviderInterface;

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

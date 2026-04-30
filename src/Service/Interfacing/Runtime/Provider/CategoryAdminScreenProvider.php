<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Runtime\Provider;

use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenProviderInterface;

final class CategoryAdminScreenProvider implements ScreenProviderInterface
{
    public function id(): string
    {
        return 'category-admin';
    }

    public function map(): array
    {
        return [
            'category-admin' => 'InterfacingCategoryAdmin',
        ];
    }
}

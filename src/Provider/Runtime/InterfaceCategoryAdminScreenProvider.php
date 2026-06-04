<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Runtime;

use App\Interfacing\ProviderInterface\Runtime\InterfaceScreenProviderInterface;

final class InterfaceCategoryAdminScreenProvider implements InterfaceScreenProviderInterface
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

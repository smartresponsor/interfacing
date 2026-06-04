<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Runtime\Context;

use App\Interfacing\ProviderInterface\Context\InterfaceBaseContextProviderInterface;

final class InterfaceDemoBaseContextProvider implements InterfaceBaseContextProviderInterface
{
    public function provide(): array
    {
        return [
            'tenantId' => 'demo',
            'userId' => 'demo',
        ];
    }
}

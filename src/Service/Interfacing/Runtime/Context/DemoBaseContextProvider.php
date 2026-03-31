<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Runtime\Context;

use App\ServiceInterface\Interfacing\Context\BaseContextProviderInterface;

final class DemoBaseContextProvider implements BaseContextProviderInterface
{
    public function provide(): array
    {
        return [
            'tenantId' => 'demo',
            'userId' => 'demo',
        ];
    }
}

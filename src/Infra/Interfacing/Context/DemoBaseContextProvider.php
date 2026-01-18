<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Infra\Interfacing\Context;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Context\BaseContextProviderInterface;

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

<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Infra\Interfacing\Context;

use App\DomainInterface\Interfacing\Context\BaseContextProviderInterface;

/**
 *
 */

/**
 *
 */
final class DemoBaseContextProvider implements BaseContextProviderInterface
{
    /**
     * @return string[]
     */
    public function provide(): array
    {
        return [
            'tenantId' => 'demo',
            'userId' => 'demo',
        ];
    }
}

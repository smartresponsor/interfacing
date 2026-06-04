<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Provider\Demo;

use App\Interfacing\ProviderInterface\Action\InterfaceActionProviderInterface;

final readonly class InterfaceDemoActionProvider implements InterfaceActionProviderInterface
{
    /**
     * @param \App\Interfacing\Endpoint\Demo\InterfaceDemoPingActionEndpoint $ping
     */
    public function __construct(private InterfaceDemoPingActionEndpoint $ping)
    {
    }

    /**
     * @return \App\Interfacing\Endpoint\Demo\InterfaceDemoPingActionEndpoint[]
     */
    public function provide(): array
    {
        return [$this->ping];
    }
}

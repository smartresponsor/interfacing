<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Demo;

use App\Interfacing\ServiceInterface\Interfacing\Action\ActionProviderInterface;

/**
 *
 */

/**
 *
 */
final readonly class DemoActionProvider implements ActionProviderInterface
{
    /**
     * @param \App\Interfacing\Service\Interfacing\Demo\DemoPingActionEndpoint $ping
     */
    public function __construct(private DemoPingActionEndpoint $ping)
    {
    }

    /**
     * @return \App\Interfacing\Service\Interfacing\Demo\DemoPingActionEndpoint[]
     */
    public function provide(): array
    {
        return [$this->ping];
    }
}

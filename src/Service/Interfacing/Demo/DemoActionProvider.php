<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\Service\Interfacing\Demo;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action\ActionProviderInterface;

final class DemoActionProvider implements ActionProviderInterface
{
    public function __construct(private readonly DemoPingActionEndpoint $ping) {}

    public function provide(): array
    {
        return [$this->ping];
    }
}


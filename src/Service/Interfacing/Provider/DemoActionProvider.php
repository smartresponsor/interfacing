<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Provider;

use App\Interfacing\Service\Interfacing\Provider\DemoAction\DemoRefreshMetricActionEndpoint;
use App\Interfacing\Service\Interfacing\Provider\DemoAction\DemoSaveProfileActionEndpoint;
use App\Interfacing\Service\Interfacing\Provider\DemoAction\DemoWizardBackActionEndpoint;
use App\Interfacing\Service\Interfacing\Provider\DemoAction\DemoWizardNextActionEndpoint;
use App\Interfacing\ServiceInterface\Interfacing\Provider\ActionProviderInterface;

/**
 *
 */

/**
 *
 */
final class DemoActionProvider implements ActionProviderInterface
{
    /**
     * @return array|\App\Interfacing\ServiceInterface\Interfacing\Action\ActionEndpointInterface[]
     */
    public function provide(): array
    {
        return [
            new DemoSaveProfileActionEndpoint(),
            new DemoRefreshMetricActionEndpoint(),
            new DemoWizardNextActionEndpoint(),
            new DemoWizardBackActionEndpoint(),
        ];
    }
}

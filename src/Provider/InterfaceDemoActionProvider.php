<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Provider;

use App\Interfacing\Endpoint\Provider\DemoAction\InterfaceDemoRefreshMetricActionEndpoint;
use App\Interfacing\Endpoint\Provider\DemoAction\InterfaceDemoSaveProfileActionEndpoint;
use App\Interfacing\Endpoint\Provider\DemoAction\InterfaceDemoWizardBackActionEndpoint;
use App\Interfacing\Endpoint\Provider\DemoAction\InterfaceDemoWizardNextActionEndpoint;
use App\Interfacing\ProviderInterface\InterfaceActionProviderInterface;

final class InterfaceDemoActionProvider implements InterfaceActionProviderInterface
{
    /**
     * @return array|\App\Interfacing\EndpointInterface\Action\InterfaceActionEndpointInterface[]
     */
    public function provide(): array
    {
        return [
            new InterfaceDemoSaveProfileActionEndpoint(),
            new InterfaceDemoRefreshMetricActionEndpoint(),
            new InterfaceDemoWizardNextActionEndpoint(),
            new InterfaceDemoWizardBackActionEndpoint(),
        ];
    }
}

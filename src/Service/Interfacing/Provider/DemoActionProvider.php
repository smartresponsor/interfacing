<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Service\Interfacing\Provider;

    use App\Service\Interfacing\Provider\DemoAction\DemoRefreshMetricActionEndpoint;
use App\Service\Interfacing\Provider\DemoAction\DemoSaveProfileActionEndpoint;
use App\Service\Interfacing\Provider\DemoAction\DemoWizardBackActionEndpoint;
use App\Service\Interfacing\Provider\DemoAction\DemoWizardNextActionEndpoint;
use App\ServiceInterface\Interfacing\Provider\ActionProviderInterface;

final class DemoActionProvider implements ActionProviderInterface
{
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


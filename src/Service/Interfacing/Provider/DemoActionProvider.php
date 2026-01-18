    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Provider;

    use SmartResponsor\Interfacing\Service\Interfacing\Provider\DemoAction\DemoRefreshMetricActionEndpoint;
use SmartResponsor\Interfacing\Service\Interfacing\Provider\DemoAction\DemoSaveProfileActionEndpoint;
use SmartResponsor\Interfacing\Service\Interfacing\Provider\DemoAction\DemoWizardBackActionEndpoint;
use SmartResponsor\Interfacing\Service\Interfacing\Provider\DemoAction\DemoWizardNextActionEndpoint;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Provider\ActionProviderInterface;

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


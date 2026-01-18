<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Runtime\Provider;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenProviderInterface;

final class DemoScreenProvider implements ScreenProviderInterface
{
    public function id(): string
    {
        return 'demo';
    }

    public function map(): array
    {
        return [
            'screen-metric-demo' => 'interfacing_screen_metric_demo',
            'screen-form-demo' => 'interfacing_screen_form_demo',
            'screen-wizard-demo' => 'interfacing_screen_wizard_demo',
        ];
    }
}

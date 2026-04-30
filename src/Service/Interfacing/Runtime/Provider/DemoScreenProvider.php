<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\Runtime\Provider;

use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenProviderInterface;

/**
 *
 */

/**
 *
 */
final class DemoScreenProvider implements ScreenProviderInterface
{
    /**
     * @return string
     */
    public function id(): string
    {
        return 'demo';
    }

    /**
     * @return string[]
     */
    public function map(): array
    {
        return [
            'screen-metric-demo' => 'interfacing_screen_metric_demo',
            'screen-form-demo' => 'interfacing_screen_form_demo',
            'screen-wizard-demo' => 'interfacing_screen_wizard_demo',
        ];
    }
}

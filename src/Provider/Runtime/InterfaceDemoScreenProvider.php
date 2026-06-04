<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Provider\Runtime;

use App\Interfacing\ProviderInterface\Runtime\InterfaceScreenProviderInterface;

final class InterfaceDemoScreenProvider implements InterfaceScreenProviderInterface
{
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

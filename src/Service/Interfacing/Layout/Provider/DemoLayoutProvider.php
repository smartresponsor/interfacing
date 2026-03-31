<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Service\Interfacing\Layout\Provider;

use App\Contract\ValueObject\ScreenId;
use App\Contract\View\LayoutScreenSpec;
use App\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;

final class DemoLayoutProvider implements LayoutProviderInterface
{
    public function id(): string
    {
        return 'demo';
    }

    public function list(): array
    {
        return [
            new LayoutScreenSpec('metrics-demo', 'Metrics demo', 'tool', ScreenId::fromString('screen-metric-demo'), null, null, 10),
            new LayoutScreenSpec('form-demo', 'Form demo', 'tool', ScreenId::fromString('screen-form-demo'), null, null, 20),
            new LayoutScreenSpec('wizard-demo', 'Wizard demo', 'tool', ScreenId::fromString('screen-wizard-demo'), null, null, 30),
        ];
    }
}

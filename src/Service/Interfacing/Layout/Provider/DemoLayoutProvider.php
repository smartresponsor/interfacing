<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Layout\Provider;

use App\Interfacing\Contract\ValueObject\ScreenId;
use App\Interfacing\Contract\View\LayoutScreenSpec;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;

final class DemoLayoutProvider implements LayoutProviderInterface
{
    public function id(): string
    {
        return 'demo';
    }

    public function provide(): array
    {
        return [
            new LayoutScreenSpec(
                block: [],
                id: 'metrics-demo',
                title: 'Metrics demo',
                navGroup: 'tool',
                screenId: ScreenId::fromString('screen-metric-demo'),
                routePath: null,
                navOrder: 10,
            ),
            new LayoutScreenSpec(
                block: [],
                id: 'form-demo',
                title: 'Form demo',
                navGroup: 'tool',
                screenId: ScreenId::fromString('screen-form-demo'),
                routePath: null,
                navOrder: 20,
            ),
            new LayoutScreenSpec(
                block: [],
                id: 'wizard-demo',
                title: 'Wizard demo',
                navGroup: 'tool',
                screenId: ScreenId::fromString('screen-wizard-demo'),
                routePath: null,
                navOrder: 30,
            ),
        ];
    }
}

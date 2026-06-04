<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Layout;

use App\Interfacing\Contract\ValueObject\InterfaceScreenId;
use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\ProviderInterface\Layout\InterfaceLayoutProviderInterface;

final class InterfaceDemoLayoutProvider implements InterfaceLayoutProviderInterface
{
    public function id(): string
    {
        return 'demo';
    }

    public function provide(): array
    {
        return [
            new InterfaceLayoutScreenSpec(
                block: [],
                id: 'metrics-demo',
                title: 'Metrics demo',
                navGroup: 'tool',
                screenId: InterfaceScreenId::fromString('screen-metric-demo'),
                routePath: null,
                navOrder: 10,
            ),
            new InterfaceLayoutScreenSpec(
                block: [],
                id: 'form-demo',
                title: 'Form demo',
                navGroup: 'tool',
                screenId: InterfaceScreenId::fromString('screen-form-demo'),
                routePath: null,
                navOrder: 20,
            ),
            new InterfaceLayoutScreenSpec(
                block: [],
                id: 'wizard-demo',
                title: 'Wizard demo',
                navGroup: 'tool',
                screenId: InterfaceScreenId::fromString('screen-wizard-demo'),
                routePath: null,
                navOrder: 30,
            ),
        ];
    }
}

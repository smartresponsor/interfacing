<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Endpoint\Provider\DemoAction;

use App\Interfacing\Contract\Runtime\InterfaceActionRequest;
use App\Interfacing\Contract\Runtime\InterfaceActionResult;
use App\Interfacing\EndpointInterface\AttributeRegistry\InterfaceActionEndpointInterface;

final class InterfaceDemoWizardBackActionEndpoint implements InterfaceActionEndpointInterface
{
    public function screenId(): string
    {
        return 'demo.wizard';
    }

    public function actionId(): string
    {
        return 'wizard-back';
    }

    public function title(): string
    {
        return 'Back';
    }

    public function order(): int
    {
        return 100;
    }

    public function handle(InterfaceActionRequest $request): InterfaceActionResult
    {
        $state = $request->state;
        $step = (int) ($state['wizard']['step'] ?? 0);
        $prev = max($step - 1, 0);

        return InterfaceActionResult::ok([
            'wizard' => ['step' => $prev],
        ]);
    }
}

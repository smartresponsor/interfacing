<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Provider\DemoAction;

use App\Interfacing\ServiceInterface\Interfacing\Registry\ActionEndpointInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult;

final class DemoWizardBackActionEndpoint implements ActionEndpointInterface
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

    public function handle(ActionRequest $request): ActionResult
    {
        $state = $request->state;
        $step = (int) ($state['wizard']['step'] ?? 0);
        $prev = max($step - 1, 0);

        return ActionResult::ok([
            'wizard' => ['step' => $prev],
        ]);
    }
}

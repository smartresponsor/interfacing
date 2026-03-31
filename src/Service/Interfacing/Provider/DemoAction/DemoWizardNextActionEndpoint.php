<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Provider\DemoAction;

use App\ServiceInterface\Interfacing\Registry\ActionEndpointInterface;
use App\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\ServiceInterface\Interfacing\Runtime\ActionResult;

final class DemoWizardNextActionEndpoint implements ActionEndpointInterface
{
    public function screenId(): string
    {
        return 'demo.wizard';
    }

    public function actionId(): string
    {
        return 'wizard-next';
    }

    public function title(): string
    {
        return 'Next';
    }

    public function order(): int
    {
        return 100;
    }

    public function handle(ActionRequest $request): ActionResult
    {
        $state = $request->state;
        $step = (int) ($state['wizard']['step'] ?? 0);
        $next = min($step + 1, 2);

        return ActionResult::ok([
            'wizard' => ['step' => $next],
        ]);
    }
}

<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Service\Interfacing\Provider\DemoAction;

    use App\Domain\Interfacing\Model\Action\ActionResult;
use App\DomainInterface\Interfacing\Model\Action\ActionRequestInterface;
use App\DomainInterface\Interfacing\Model\Action\ActionResultInterface;
use App\ServiceInterface\Interfacing\Action\ActionEndpointInterface;

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

    public function handle(ActionRequestInterface $request): ActionResultInterface
    {
        $state = $request->state();
        $step = (int) ($state['wizard']['step'] ?? 0);
        $prev = max($step - 1, 0);

        return ActionResult::ok([
            'wizard' => ['step' => $prev],
        ]);
    }
}


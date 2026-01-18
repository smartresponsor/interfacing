<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Provider\DemoAction;

    use SmartResponsor\Interfacing\Domain\Interfacing\Model\Action\ActionResult;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Action\ActionRequestInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Action\ActionResultInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action\ActionEndpointInterface;

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

    public function handle(ActionRequestInterface $request): ActionResultInterface
    {
        $state = $request->state();
        $step = (int) ($state['wizard']['step'] ?? 0);
        $next = min($step + 1, 2);

        return ActionResult::ok([
            'wizard' => ['step' => $next],
        ]);
    }
}


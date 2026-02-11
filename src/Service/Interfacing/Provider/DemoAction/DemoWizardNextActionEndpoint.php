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

    /**
     *
     */

    /**
     *
     */
    final class DemoWizardNextActionEndpoint implements ActionEndpointInterface
{
    /**
     * @return string
     */
    public function screenId(): string
    {
        return 'demo.wizard';
    }

    /**
     * @return string
     */
    public function actionId(): string
    {
        return 'wizard-next';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Next';
    }

    /**
     * @param \App\DomainInterface\Interfacing\Model\Action\ActionRequestInterface $request
     * @return \App\DomainInterface\Interfacing\Model\Action\ActionResultInterface
     */
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


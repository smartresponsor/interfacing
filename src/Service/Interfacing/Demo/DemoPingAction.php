<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Service\Interfacing\Demo;

    use App\Domain\Interfacing\Attribute\AsInterfacingAction;
use App\ServiceInterface\Interfacing\Registry\ActionEndpointInterface;
use App\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\ServiceInterface\Interfacing\Runtime\ActionResult;

    /**
     *
     */

    /**
     *
     */
    #[AsInterfacingAction(
    screenId: 'interfacing.doctor',
    id: 'ping',
    title: 'Ping',
    order: 1,
)]
final class DemoPingAction implements ActionEndpointInterface
{
    /**
     * @return string
     */
    public function screenId(): string
    {
        return 'interfacing.doctor';
    }

    /**
     * @return string
     */
    public function actionId(): string
    {
        return 'ping';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Ping';
    }

    /**
     * @return int
     */
    public function order(): int
    {
        return 1;
    }

    /**
     * @param \App\ServiceInterface\Interfacing\Runtime\ActionRequest $request
     * @return \App\ServiceInterface\Interfacing\Runtime\ActionResult
     */
    public function handle(ActionRequest $request): ActionResult
    {
        return ActionResult::ok([
            'pong' => true,
            'at' => (new \DateTimeImmutable('now'))->format(DATE_ATOM),
        ]);
    }
}


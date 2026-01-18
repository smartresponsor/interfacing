<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Demo;

    use SmartResponsor\Interfacing\Domain\Interfacing\Attribute\AsInterfacingAction;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Registry\ActionEndpointInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ActionRequest;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult;

#[AsInterfacingAction(
    screenId: 'interfacing.doctor',
    id: 'ping',
    title: 'Ping',
    order: 1,
)]
final class DemoPingAction implements ActionEndpointInterface
{
    public function screenId(): string
    {
        return 'interfacing.doctor';
    }

    public function actionId(): string
    {
        return 'ping';
    }

    public function title(): string
    {
        return 'Ping';
    }

    public function order(): int
    {
        return 1;
    }

    public function handle(ActionRequest $request): ActionResult
    {
        return ActionResult::ok([
            'pong' => true,
            'at' => (new \DateTimeImmutable('now'))->format(DATE_ATOM),
        ]);
    }
}


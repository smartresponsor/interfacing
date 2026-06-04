<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Action\Demo;

use App\Interfacing\Contract\Runtime\InterfaceActionRequest;
use App\Interfacing\Contract\Runtime\InterfaceActionResult;
use App\Interfacing\EndpointInterface\AttributeRegistry\InterfaceActionEndpointInterface;
use App\Interfacing\Integration\Symfony\Attribute\InterfaceAsAction;

#[InterfaceAsAction(
    screenId: 'interfacing-doctor',
    id: 'ping',
    title: 'Ping',
    order: 1,
)]
final class InterfaceDemoPingAction implements InterfaceActionEndpointInterface
{
    public function screenId(): string
    {
        return 'interfacing-doctor';
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

    public function handle(InterfaceActionRequest $request): InterfaceActionResult
    {
        return InterfaceActionResult::ok([
            'pong' => true,
            'at' => (new \DateTimeImmutable('now'))->format(DATE_ATOM),
        ]);
    }
}

<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Demo;

use App\Domain\Interfacing\Action\ActionId;
use App\Domain\Interfacing\Action\ActionResult;
use App\Domain\Interfacing\Ui\UiMessage;
use App\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use App\DomainInterface\Interfacing\Action\ActionIdInterface;
use App\DomainInterface\Interfacing\Action\ActionResultInterface;
use App\DomainInterface\Interfacing\Action\ActionRuntimeInterface;

final class DemoPingActionEndpoint implements ActionEndpointInterface
{
    public function id(): ActionIdInterface
    {
        return new ActionId('interfacing_demo_ping');
    }

    public function run(array $input, ActionRuntimeInterface $runtime): ActionResultInterface
    {
        $runtime->addMessage(new UiMessage('info', 'pong', 'pong'));
        return ActionResult::ok(['pong' => true]);
    }
}


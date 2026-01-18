<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\Service\Interfacing\Demo;

use SmartResponsor\Interfacing\Domain\Interfacing\Action\ActionId;
use SmartResponsor\Interfacing\Domain\Interfacing\Action\ActionResult;
use SmartResponsor\Interfacing\Domain\Interfacing\Ui\UiMessage;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Action\ActionIdInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Action\ActionResultInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Action\ActionRuntimeInterface;

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


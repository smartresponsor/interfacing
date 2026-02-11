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

/**
 *
 */

/**
 *
 */
final class DemoPingActionEndpoint implements ActionEndpointInterface
{
    /**
     * @return \App\Domain\Interfacing\Action\ActionId
     */
    public function id(): ActionId
    {
        return new ActionId('interfacing_demo_ping');
    }

    /**
     * @param array $input
     * @param \App\DomainInterface\Interfacing\Action\ActionRuntimeInterface $runtime
     * @return \App\Domain\Interfacing\Action\ActionResult
     */
    public function run(array $input, ActionRuntimeInterface $runtime): ActionResult
    {
        $runtime->addMessage(new UiMessage('info', 'pong', 'pong'));
        return ActionResult::ok(['pong' => true]);
    }
}


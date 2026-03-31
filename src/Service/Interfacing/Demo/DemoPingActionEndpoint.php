<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Demo;

use App\Contract\Action\ActionResult;
use App\Contract\Action\ActionRuntimeInterface;
use App\Contract\Ui\UiMessage;
use App\Contract\ValueObject\ActionId;
use App\ServiceInterface\Interfacing\Action\ActionEndpointInterface;

final class DemoPingActionEndpoint implements ActionEndpointInterface
{
    public function id(): ActionId
    {
        return ActionId::of('interfacing_demo_ping');
    }

    public function run(array $input, ActionRuntimeInterface $runtime): ActionResult
    {
        $runtime->addMessage(new UiMessage('info', 'pong', 'pong'));

        return ActionResult::ok(['pong' => true]);
    }
}

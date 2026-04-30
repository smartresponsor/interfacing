<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Demo;

use App\Interfacing\Contract\Action\ActionResult;
use App\Interfacing\Contract\Action\ActionRuntimeInterface;
use App\Interfacing\Contract\Ui\UiMessage;
use App\Interfacing\Contract\ValueObject\ActionId;
use App\Interfacing\ServiceInterface\Interfacing\Action\ActionEndpointInterface;

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

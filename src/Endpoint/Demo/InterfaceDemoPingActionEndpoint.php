<?php

declare(strict_types=1);

namespace App\Interfacing\Endpoint\Demo;

use App\Interfacing\Contract\Action\InterfaceActionResult;
use App\Interfacing\Contract\Action\InterfaceActionRuntimeInterface;
use App\Interfacing\Contract\Ui\InterfaceUiMessage;
use App\Interfacing\Contract\ValueObject\InterfaceActionId;
use App\Interfacing\EndpointInterface\Action\InterfaceActionEndpointInterface;

final class InterfaceDemoPingActionEndpoint implements InterfaceActionEndpointInterface
{
    public function id(): InterfaceActionId
    {
        return InterfaceActionId::of('interfacing_demo_ping');
    }

    public function run(array $input, InterfaceActionRuntimeInterface $runtime): InterfaceActionResult
    {
        $runtime->addMessage(new InterfaceUiMessage('info', 'pong', 'pong'));

        return InterfaceActionResult::ok(['pong' => true]);
    }
}

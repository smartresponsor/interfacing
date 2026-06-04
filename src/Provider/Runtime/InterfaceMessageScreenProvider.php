<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Runtime;

use App\Interfacing\ProviderInterface\Runtime\InterfaceScreenProviderInterface;

final class InterfaceMessageScreenProvider implements InterfaceScreenProviderInterface
{
    public function id(): string
    {
        return 'message';
    }

    public function map(): array
    {
        return [
            'message.digest' => 'interfacing_screen',
            'message.notifications.inbox' => 'interfacing_screen',
            'message.search.results' => 'interfacing_screen',
            'message.rooms.collection' => 'interfacing_screen',
        ];
    }
}

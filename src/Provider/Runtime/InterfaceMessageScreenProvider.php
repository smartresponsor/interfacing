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
            'message.digest' => 'interfacing_screen_show',
            'message.notification.inbox' => 'interfacing_screen_show',
            'message.search.result' => 'interfacing_screen_show',
            'message.room.collection' => 'interfacing_screen_show',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Runtime\Provider;

use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenProviderInterface;

final class MessageScreenProvider implements ScreenProviderInterface
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

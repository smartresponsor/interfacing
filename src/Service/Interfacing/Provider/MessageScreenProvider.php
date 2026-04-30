<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Provider;

use App\Interfacing\Contract\View\LayoutScreenSpec;
use App\Interfacing\Contract\View\ScreenSpec;
use App\Interfacing\ServiceInterface\Interfacing\Provider\ScreenProviderInterface;

final class MessageScreenProvider implements ScreenProviderInterface
{
    public function provide(): array
    {
        return [
            new ScreenSpec(
                'message.notifications.inbox',
                'Notification inbox',
                new LayoutScreenSpec(id: 'message.notifications.inbox', title: 'Notification inbox', routePath: 'interfacing/screen/message/notifications-inbox'),
                [],
                [],
                'Messaging notifications rendered in the Interfacing shell.',
                'interfacing/screen/message/notifications-inbox',
            ),
            new ScreenSpec(
                'message.search.results',
                'Search results',
                new LayoutScreenSpec(id: 'message.search.results', title: 'Search results', routePath: 'interfacing/screen/message/search-results'),
                [],
                [],
                'Messaging search results rendered in the Interfacing shell.',
                'interfacing/screen/message/search-results',
            ),
            new ScreenSpec(
                'message.rooms.collection',
                'Rooms collection',
                new LayoutScreenSpec(id: 'message.rooms.collection', title: 'Rooms collection', routePath: 'interfacing/screen/message/rooms-collection'),
                [],
                [],
                'Messaging rooms rendered in the Interfacing shell.',
                'interfacing/screen/message/rooms-collection',
            ),
        ];
    }
}

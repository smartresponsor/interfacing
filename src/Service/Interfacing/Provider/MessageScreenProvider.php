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
                'message.digest',
                'Digest',
                new LayoutScreenSpec([
                    new \App\Interfacing\Contract\View\LayoutBlockSpec('collection', 'digest', [
                        'title' => 'Messaging digest',
                        'subtitle' => 'A compact digest surfaced for the Interfacing shell.',
                        'items' => [
                            [
                                'title' => 'Unread digest',
                                'subtitle' => 'Latest unread thread summary ready for review.',
                                'meta' => ['kind' => 'digest', 'priority' => 'high'],
                            ],
                            [
                                'title' => 'Pending notifications',
                                'subtitle' => 'Notifications queued for presentation.',
                                'meta' => ['kind' => 'digest', 'priority' => 'medium'],
                            ],
                            [
                                'title' => 'Room highlights',
                                'subtitle' => 'Recent activity across active rooms.',
                                'meta' => ['kind' => 'digest', 'priority' => 'low'],
                            ],
                        ],
                    ]),
                ], id: 'message.digest', title: 'Digest', routePath: 'message/digest'),
                [],
                [],
                'Messaging digest rendered in the Interfacing shell.',
                'message/digest',
            ),
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

<?php

declare(strict_types=1);

namespace App\Interfacing\Provider;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\Contract\View\InterfaceScreenSpec;
use App\Interfacing\ProviderInterface\InterfaceScreenProviderInterface;

final class InterfaceMessageScreenProvider implements InterfaceScreenProviderInterface
{
    public function provide(): array
    {
        return [
            new InterfaceScreenSpec(
                'message.digest',
                'Digest',
                new InterfaceLayoutScreenSpec([
                    new \App\Interfacing\Contract\View\InterfaceLayoutBlockSpec('collection', 'digest', [
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
            new InterfaceScreenSpec(
                'message.notification.inbox',
                'Notification inbox',
                new InterfaceLayoutScreenSpec(id: 'message.notification.inbox', title: 'Notification inbox', routePath: 'screen/interfacing/showcase/message/notifications-inbox'),
                [],
                [],
                'Messaging notifications rendered in the Interfacing shell.',
                'screen/interfacing/showcase/message/notifications-inbox',
            ),
            new InterfaceScreenSpec(
                'message.search.result',
                'Search results',
                new InterfaceLayoutScreenSpec(id: 'message.search.result', title: 'Search results', routePath: 'screen/interfacing/showcase/message/search-results'),
                [],
                [],
                'Messaging search results rendered in the Interfacing shell.',
                'screen/interfacing/showcase/message/search-results',
            ),
            new InterfaceScreenSpec(
                'message.room.collection',
                'Rooms collection',
                new InterfaceLayoutScreenSpec(id: 'message.room.collection', title: 'Rooms collection', routePath: 'screen/interfacing/showcase/message/rooms-collection'),
                [],
                [],
                'Messaging rooms rendered in the Interfacing shell.',
                'screen/interfacing/showcase/message/rooms-collection',
            ),
        ];
    }
}

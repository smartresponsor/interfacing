<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Layout\Provider;

use App\Interfacing\Contract\ValueObject\ScreenId;
use App\Interfacing\Contract\View\LayoutBlockSpec;
use App\Interfacing\Contract\View\LayoutScreenSpec;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;

final class MessageLayoutProvider implements LayoutProviderInterface
{
    public function id(): string
    {
        return 'message';
    }

    public function provide(): array
    {
        return [
            new LayoutScreenSpec(
                [
                    new LayoutBlockSpec('collection', 'notifications', [
                        'title' => 'Notification inbox',
                        'subtitle' => 'Recent messaging notifications surfaced for Interfacing.',
                        'items' => [
                            [
                                'title' => 'Thread reply received',
                                'subtitle' => 'A new reply landed in the active thread.',
                                'meta' => ['kind' => 'reply', 'priority' => 'high'],
                            ],
                            [
                                'title' => 'Room invite pending',
                                'subtitle' => 'A collaborator invite is waiting for review.',
                                'meta' => ['kind' => 'invite', 'priority' => 'medium'],
                            ],
                            [
                                'title' => 'Digest ready',
                                'subtitle' => 'The latest digest is ready for presentation.',
                                'meta' => ['kind' => 'digest', 'priority' => 'low'],
                            ],
                        ],
                    ]),
                ],
                id: 'message.notifications.inbox',
                title: 'Notification inbox',
                navGroup: 'message',
                screenId: ScreenId::fromString('message.notifications.inbox'),
                routePath: 'interfacing/screen/message/notifications-inbox',
                navOrder: 10,
            ),
            new LayoutScreenSpec(
                [
                    new LayoutBlockSpec('collection', 'search-results', [
                        'title' => 'Search results',
                        'subtitle' => 'Messaging search output prepared for review.',
                        'items' => [
                            [
                                'title' => 'Result: policy update',
                                'subtitle' => 'Matches the query in thread metadata.',
                                'meta' => ['room' => 'general', 'score' => '0.93'],
                            ],
                            [
                                'title' => 'Result: moderation note',
                                'subtitle' => 'Relevant in-room moderation result.',
                                'meta' => ['room' => 'ops', 'score' => '0.87'],
                            ],
                        ],
                    ]),
                ],
                id: 'message.search.results',
                title: 'Search results',
                navGroup: 'message',
                screenId: ScreenId::fromString('message.search.results'),
                routePath: 'interfacing/screen/message/search-results',
                navOrder: 20,
            ),
            new LayoutScreenSpec(
                [
                    new LayoutBlockSpec('collection', 'rooms', [
                        'title' => 'Room collection',
                        'subtitle' => 'Messaging room list prepared for the interface.',
                        'items' => [
                            [
                                'title' => 'General',
                                'subtitle' => 'Shared project conversation.',
                                'meta' => ['slug' => 'general', 'visibility' => 'public'],
                            ],
                            [
                                'title' => 'Moderation',
                                'subtitle' => 'Operations and moderation workflow.',
                                'meta' => ['slug' => 'moderation', 'visibility' => 'private'],
                            ],
                            [
                                'title' => 'Launch team',
                                'subtitle' => 'Cross-functional launch coordination.',
                                'meta' => ['slug' => 'launch-team', 'visibility' => 'private'],
                            ],
                        ],
                    ]),
                ],
                id: 'message.rooms.collection',
                title: 'Rooms collection',
                navGroup: 'message',
                screenId: ScreenId::fromString('message.rooms.collection'),
                routePath: 'interfacing/screen/message/rooms-collection',
                navOrder: 30,
            ),
        ];
    }
}

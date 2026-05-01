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
            $this->collectionScreen(
                id: 'message.digest',
                title: 'Digest',
                blockId: 'digest',
                blockTitle: 'Messaging digest',
                routePath: 'message/digest',
                navOrder: 5,
            ),
            $this->collectionScreen(
                id: 'message.notifications.inbox',
                title: 'Notification inbox',
                blockId: 'notifications',
                blockTitle: 'Notification inbox',
                routePath: 'interfacing/screen/message/notifications-inbox',
                navOrder: 10,
            ),
            $this->collectionScreen(
                id: 'message.search.results',
                title: 'Search results',
                blockId: 'search-results',
                blockTitle: 'Search results',
                routePath: 'interfacing/screen/message/search-results',
                navOrder: 20,
            ),
            $this->collectionScreen(
                id: 'message.rooms.collection',
                title: 'Rooms collection',
                blockId: 'rooms',
                blockTitle: 'Room collection',
                routePath: 'interfacing/screen/message/rooms-collection',
                navOrder: 30,
            ),
        ];
    }

    private function collectionScreen(
        string $id,
        string $title,
        string $blockId,
        string $blockTitle,
        string $routePath,
        int $navOrder,
    ): LayoutScreenSpec {
        return new LayoutScreenSpec(
            [
                new LayoutBlockSpec('collection', $blockId, [
                    'title' => $blockTitle,
                    'subtitle' => 'Screen contract only; business fixtures and live rows must come from Messaging.',
                    'items' => [],
                    'emptyTitle' => 'Component data not connected',
                    'emptyText' => 'Interfacing owns chrome and rendering discipline only. Messaging must provide fixtures or live data for this collection.',
                ]),
            ],
            id: $id,
            title: $title,
            navGroup: 'message',
            screenId: ScreenId::fromString($id),
            routePath: $routePath,
            navOrder: $navOrder,
        );
    }
}

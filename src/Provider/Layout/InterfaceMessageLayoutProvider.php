<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Layout;

use App\Interfacing\Contract\ValueObject\InterfaceScreenId;
use App\Interfacing\Contract\View\InterfaceLayoutBlockSpec;
use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\ProviderInterface\Layout\InterfaceLayoutProviderInterface;

final class InterfaceMessageLayoutProvider implements InterfaceLayoutProviderInterface
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
                id: 'message.notification.inbox',
                title: 'Notification inbox',
                blockId: 'notifications',
                blockTitle: 'Notification inbox',
                routePath: 'screen/interfacing/showcase/message/notifications-inbox',
                navOrder: 10,
            ),
            $this->collectionScreen(
                id: 'message.search.result',
                title: 'Search results',
                blockId: 'search-results',
                blockTitle: 'Search results',
                routePath: 'screen/interfacing/showcase/message/search-results',
                navOrder: 20,
            ),
            $this->collectionScreen(
                id: 'message.room.collection',
                title: 'Rooms collection',
                blockId: 'rooms',
                blockTitle: 'Room collection',
                routePath: 'screen/interfacing/showcase/message/rooms-collection',
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
    ): InterfaceLayoutScreenSpec {
        return new InterfaceLayoutScreenSpec(
            [
                new InterfaceLayoutBlockSpec('collection', $blockId, [
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
            screenId: InterfaceScreenId::fromString($id),
            routePath: $routePath,
            navOrder: $navOrder,
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing;

use App\Interfacing\Contract\View\ShellNavGroup;
use App\Interfacing\Contract\View\ShellNavItem;
use App\Interfacing\ServiceInterface\Interfacing\ShellNavProviderInterface;

final class ShellNavProvider implements ShellNavProviderInterface
{
    public function provide(): array
    {
        return [
            new ShellNavGroup('interfacing', 'Interfacing', [
                new ShellNavItem('interfacing-doctor', 'Doctor', '/interfacing/screen/interfacing-doctor', 'interfacing'),
            ]),
            new ShellNavGroup('message', 'Messaging', [
                new ShellNavItem('message.notifications.inbox', 'Notification inbox', '/interfacing/screen/message.notifications.inbox', 'message'),
                new ShellNavItem('message.search.results', 'Search results', '/interfacing/screen/message.search.results', 'message'),
                new ShellNavItem('message.rooms.collection', 'Rooms collection', '/interfacing/screen/message.rooms.collection', 'message'),
            ]),
            new ShellNavGroup('component', 'Component', [
                new ShellNavItem('category-admin', 'Category Admin', '/interfacing/screen/category-admin', 'component'),
            ]),
        ];
    }
}

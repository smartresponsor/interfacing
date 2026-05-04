<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class MessagingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('messaging.message', 'Messaging', 'Message', 'message', 'Generic CRUD path for message records complements custom inbox/room bridges.'),
            $this->canonicalResource('messaging.room', 'Messaging', 'Room', 'room', 'Room CRUD path lets you inspect generic collection/edit flows alongside custom room consoles.'),
            $this->canonicalResource('messaging.thread', 'Messaging', 'Thread', 'thread', 'Thread CRUD path is shown even when the host has not yet exposed a concrete thread screen.'),
            $this->canonicalResource('messaging.notification', 'Messaging', 'Notification', 'notification', 'Notification CRUD path complements the custom notification inbox bridge.'),
            $this->canonicalResource('messaging.digest', 'Messaging', 'Digest', 'digest', 'Digest records are listed as first-class CRUD resources, not only as custom pages.'),
        ];
    }
}

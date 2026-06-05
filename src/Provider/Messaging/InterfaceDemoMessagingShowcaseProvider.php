<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Messaging;

use App\Interfacing\ProviderInterface\Messaging\InterfaceMessagingShowcaseProviderInterface;

/**
 * Demo-backed Messaging surface for Interfacing.
 *
 * Interfacing owns only the visual shell and storefront/workbench contract. The
 * Messaging component can later replace this provider with real rooms, chats,
 * messages, notifications, deliveries, and read-state data without replacing the
 * Twig page structure.
 */
final readonly class InterfaceDemoMessagingShowcaseProvider implements InterfaceMessagingShowcaseProviderInterface
{
    public function provide(array $criteria = []): array
    {
        $section = isset($criteria['section']) && is_string($criteria['section']) ? trim($criteria['section']) : 'overview';
        $query = isset($criteria['q']) && is_string($criteria['q']) ? trim($criteria['q']) : '';

        return [
            'id' => 'messaging.showcase',
            'title' => 'Messaging',
            'eyebrow' => 'Customer communication center',
            'summary' => 'A user-facing visual surface for inbox, compose, rooms, chats, search, notifications, and message-state verification. Demo content is provider-owned until the Messaging component supplies live data.',
            'route' => '/interfacing/showcase/message/',
            'activeSection' => $section,
            'query' => $query,
            'stats' => [
                ['label' => 'Unread', 'value' => '12'],
                ['label' => 'Rooms', 'value' => '5'],
                ['label' => 'Queued', 'value' => '3'],
                ['label' => 'Source', 'value' => 'Demo provider'],
            ],
            'navigation' => [
                ['id' => 'overview', 'title' => 'Overview', 'url' => '/interfacing/showcase/message/'],
                ['id' => 'inbox', 'title' => 'Inbox', 'url' => '/interfacing/showcase/message/inbox'],
                ['id' => 'outbox', 'title' => 'Outbox', 'url' => '/interfacing/showcase/message/outbox'],
                ['id' => 'compose', 'title' => 'Send message', 'url' => '/interfacing/showcase/message/compose'],
                ['id' => 'rooms', 'title' => 'Rooms', 'url' => '/interfacing/showcase/message/rooms'],
                ['id' => 'chats', 'title' => 'Chats', 'url' => '/interfacing/showcase/message/chats'],
                ['id' => 'search', 'title' => 'Search', 'url' => '/interfacing/showcase/message/search'],
                ['id' => 'digest', 'title' => 'Digest', 'url' => '/interfacing/showcase/message/digest'],
            ],
            'sections' => $this->sections(),
            'messages' => $this->messages($query),
            'rooms' => $this->rooms(),
            'deliveries' => $this->deliveries(),
            'compose' => $this->composeModel(),
            'handoff' => [
                'status' => 'partially connected',
                'connectedScreens' => [
                    ['title' => 'Notification inbox', 'url' => '/interfacing/showcase/message/notification/inbox'],
                    ['title' => 'Rooms collection', 'url' => '/interfacing/showcase/message/room/collection'],
                    ['title' => 'Search results', 'url' => '/interfacing/showcase/message/search/result'],
                    ['title' => 'Digest', 'url' => '/interfacing/showcase/message/digest'],
                ],
                'note' => 'Existing Interfacing layout/screen providers expose Messaging screens, but the user-facing left navigation now points to the dedicated Messaging showcase entry first.',
            ],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function sections(): array
    {
        return [
            ['id' => 'inbox', 'title' => 'Receive messages', 'summary' => 'Latest inbound messages and notifications that need review.', 'url' => '/interfacing/showcase/message/inbox', 'count' => '12'],
            ['id' => 'outbox', 'title' => 'Outbox', 'summary' => 'Outbound drafts, queued deliveries, and recently sent messages.', 'url' => '/interfacing/showcase/message/outbox', 'count' => '3'],
            ['id' => 'compose', 'title' => 'Send message', 'summary' => 'Provider-ready compose surface for customer, room, or system delivery.', 'url' => '/interfacing/showcase/message/compose', 'count' => 'Draft'],
            ['id' => 'rooms', 'title' => 'Rooms', 'summary' => 'Conversation rooms grouped by customer, order, vendor, or project context.', 'url' => '/interfacing/showcase/message/rooms', 'count' => '5'],
            ['id' => 'chats', 'title' => 'Chats', 'summary' => 'Active one-to-one and group threads with read-state signals.', 'url' => '/interfacing/showcase/message/chats', 'count' => '8'],
            ['id' => 'search', 'title' => 'Check messages', 'summary' => 'Search, inspect, and verify message status before real data integration.', 'url' => '/interfacing/showcase/message/search', 'count' => 'Ready'],
            ['id' => 'digest', 'title' => 'Digest', 'summary' => 'Compact activity digest for unread, queued, and high-priority communication.', 'url' => '/interfacing/showcase/message/digest', 'count' => '3'],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function messages(string $query): array
    {
        $messages = [
            ['id' => 'msg-1001', 'title' => 'Order shipment question', 'from' => 'Customer room', 'summary' => 'Customer asked whether the shipment can be routed to a pickup point.', 'status' => 'Unread', 'time' => '8 min ago', 'priority' => 'high', 'tags' => ['Order', 'Shipping']],
            ['id' => 'msg-1002', 'title' => 'Vendor price confirmation', 'from' => 'Vendor channel', 'summary' => 'Supplier confirmed updated price profile for the next catalog refresh.', 'status' => 'Read', 'time' => '37 min ago', 'priority' => 'medium', 'tags' => ['Vendor', 'Pricing']],
            ['id' => 'msg-1003', 'title' => 'Automation approval needed', 'from' => 'System workflow', 'summary' => 'AI automation policy gate requires operator confirmation before delivery.', 'status' => 'Pending', 'time' => '1 hr ago', 'priority' => 'high', 'tags' => ['AI', 'Policy']],
            ['id' => 'msg-1004', 'title' => 'Project intake reply', 'from' => 'Project room', 'summary' => 'New project intake response is ready for review and classification.', 'status' => 'Unread', 'time' => 'Today', 'priority' => 'normal', 'tags' => ['Project', 'Intake']],
            ['id' => 'msg-1005', 'title' => 'Queued catalog update', 'from' => 'Outbound queue', 'summary' => 'Message prepared for vendor about product price-profile refresh.', 'status' => 'Queued', 'time' => 'Draft', 'priority' => 'medium', 'tags' => ['Outbox', 'Vendor']],
        ];

        if ('' === $query) {
            return $messages;
        }

        $needle = strtolower($query);

        return array_values(array_filter($messages, static function (array $message) use ($needle): bool {
            return str_contains(strtolower(implode(' ', [
                (string) $message['title'],
                (string) $message['from'],
                (string) $message['summary'],
                implode(' ', $message['tags']),
            ])), $needle);
        }));
    }

    /** @return list<array<string, string>> */
    private function rooms(): array
    {
        return [
            ['title' => 'Customer support room', 'summary' => 'Customer-facing questions, order updates, and support replies.', 'status' => 'Active', 'url' => '#room-customer-support'],
            ['title' => 'Vendor coordination', 'summary' => 'Supplier pricing, availability, fulfillment, and SLA coordination.', 'status' => 'Active', 'url' => '#room-vendor-coordination'],
            ['title' => 'Project intake', 'summary' => 'Intellectual product/interfacing/showcase/project conversations and qualification notes.', 'status' => 'Review', 'url' => '#room-project-intake'],
        ];
    }

    /** @return list<array<string, string>> */
    private function deliveries(): array
    {
        return [
            ['label' => 'Queued outbound', 'value' => '3', 'note' => 'Waiting for policy gate'],
            ['label' => 'Delivered today', 'value' => '27', 'note' => 'Provider placeholder metric'],
            ['label' => 'Failed checks', 'value' => '1', 'note' => 'Needs operator inspection'],
        ];
    }

    /** @return array<string, mixed> */
    private function composeModel(): array
    {
        return [
            'title' => 'Send a message',
            'summary' => 'Visual compose template only. The real send handler belongs to Messaging/Accessing delivery policy.',
            'targets' => ['Customer', 'Room', 'Vendor', 'Project', 'System notification'],
            'actions' => [
                ['title' => 'Preview message', 'url' => '#preview-message'],
                ['title' => 'Save draft', 'url' => '#save-draft'],
            ],
        ];
    }
}

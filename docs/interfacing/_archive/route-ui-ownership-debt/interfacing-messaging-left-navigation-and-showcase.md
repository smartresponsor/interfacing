# Messaging left navigation and user-facing showcase

## Decision

Messaging is a business-facing ecosystem component and must appear in the primary left navigation as a user-visible capability, not only as a hidden notification link or a CRUD/screen catalog entry.

## Current bridge status

The current Interfacing slice already has partial Messaging bridge coverage:

- layout provider entries for `message.digest`, `message.notifications.inbox`, `message.search.results`, and `message.rooms.collection`;
- runtime screen map entries for the same screen IDs;
- template entries under `templates/screen/message/` for notification inbox, rooms collection, and search results;
- explicit layout routes under `/message/digest`, `/message/notifications/inbox`, `/message/search/results`, and `/message/rooms/collection`.

That means Messaging is partially connected through Interfacing layout/runtime providers, but it did not yet have a clean customer-facing entry surface in the primary left navigation.

## Change

The primary left navigation now exposes a dedicated Messaging group:

- Message center: `/message/`
- Inbox: `/message/inbox`
- Send message: `/message/compose`
- Rooms: `/message/rooms`
- Chats: `/message/chats`
- Check messages: `/message/search`

A new provider-backed Messaging showcase was added:

`InterfaceMessagingShowcaseController -> InterfaceMessagingShowcaseProviderInterface -> InterfaceDemoMessagingShowcaseProviderService -> messaging_showcase.html.twig`

The demo provider is temporary and owns placeholder message, room, compose, and delivery-check data. Twig remains a rendering contract and should not become the business data source.

## Responsibility boundary

Interfacing owns:

- shell/chrome integration;
- user-facing navigation entries;
- visual templates for Messaging overview, inbox, compose, rooms, chats, search, and digest;
- visible bridge status links to existing screen-provider routes.

Messaging owns, once integrated:

- message records;
- rooms and chats;
- send/receive handlers;
- notification delivery state;
- read-state and search indexing;
- policy-gated message sending.


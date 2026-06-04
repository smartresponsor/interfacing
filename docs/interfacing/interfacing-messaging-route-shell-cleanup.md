# Messaging route and shell cleanup

This wave fixes the user-facing `/message` chain so it does not fall through to the generic CRUD/bridge fallback.

## Problem

The visible `/message/` page could be handled by the broad generic CRUD route and rendered as a bridge/debug fallback. In that state the primary and secondary shell panels could also fall back to development-oriented Workspace/CRUD/Shell lists instead of Messaging business functions.

## Canonical behavior

`/message`, `/message/`, and `/message/{inbox|compose|rooms|chats|search|digest}` are Messaging storefront/workbench routes. They render the Messaging showcase provider/template and expose user-facing Messaging functions:

- Message center
- Inbox
- Send message
- Rooms
- Chats
- Check messages
- Digest

The generic CRUD catch-all must not own `/message` routes.

## Implementation

- Added explicit YAML routes for Messaging before broad fallback routes.
- Excluded `message` from the generic CRUD bridge route requirement.
- Added a defensive InterfaceGenericCrudWorkbenchController delegation for `/message` in case an external host route still forwards the request there.
- Replaced shell fallback navigation with business/Messaging lists so missing shell context no longer exposes dev-only CRUD/Shell menus.

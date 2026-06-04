# Interfacing left primary navigation component whitelist

The primary left panel is a user-facing component rail. It must list only top-level Smart Responsor ecosystem component bricks and must not expose host/runtime/system/discovery artifacts.

Removed from the primary left panel contract:

- 2fa
- App
- App swagger
- Bundle
- Configured resources
- Form
- Host application
- Infrastructure
- Ux

Allowed component entries are rendered from the shell chrome provider and mirrored in the Twig fallback so a missing provider payload cannot reintroduce the forbidden entries.

The secondary left panel remains the place for current-component lower-order links such as inbox/outbox/compose for Messaging or categories/products for Catalog.

# Interfacing left navigation business ecosystem audit

## Decision

The application left navigation is user-facing chrome. It must not behave as a development directory of every Interfacing route, form, screen, shell diagnostic, JSON endpoint, or CRUD/test surface.

## Implemented contract

The primary left navigation now exposes ecosystem business bricks only:

- Commerce: Catalog, Products, Cart, Orders, Payments, Shipping.
- Customer account: Profile, Security, Access, Notifications.
- Finance: Billing, Currencies, Exchange rates, Subscriptions, Commissions, Taxation.
- Ecosystem: Workspace, Applications, Components, Projects.

## Removed from primary left navigation

The following development/internal surfaces were intentionally removed from the primary user chrome:

- Launchpad.
- CRUD Explorer.
- Screens / Screen Catalog.
- Layout Preview.
- Operations workbench.
- Tables.
- Forms.
- Affordances.
- Readiness.
- Obligations.
- Bridges.
- Promotion gates.
- Contracts.
- Schemas.
- Shell Audit.
- Shell Guard.
- Shell Map.
- URL/JSON-style diagnostic surfaces.

## Template contract

The left navigation now renders groups as native `ul/li` lists with no bullets and vertical spacing, matching the same list-based direction used for footer and top quick-menu surfaces.

## Cache note

Shell chrome cache keys were bumped so deployments do not keep serving the old oversized navigation from application cache.

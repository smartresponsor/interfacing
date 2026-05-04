# Interfacing Wave 15 — Neutral CRUD Preview DTO Boundary

Wave 15 removes the last order-specific DTO dependency from the generic CRUD workbench preview provider path.

## Canonical direction

Generic CRUD bridge preview providers return Interfacing-owned neutral DTOs:

- `src/Contract/Crud/CrudPreviewPage.php`
- `src/Contract/Crud/CrudPreviewRow.php`

The provider contract is now:

- `src/ServiceInterface/Interfacing/Crud/CrudWorkbenchPreviewProviderInterface.php`

Owning components may publish resource-specific providers, but those providers must map their internal query/read models into the neutral preview DTOs before handing data to Interfacing.

## What changed

- `DefaultCrudWorkbenchPreviewProvider` no longer returns `OrderSummaryPage`.
- `CrudWorkbenchPreviewProviderInterface` now returns `CrudPreviewPage`.
- `GenericCrudWorkbenchViewBuilder` now calls `CrudWorkbenchFactory::buildCrudPreviewView()`.
- `CrudWorkbenchFactory::buildOrderSummaryView()` remains for the dedicated order-summary screen.

## Compatibility

Public URLs and route names are unchanged. The rendered Twig payload shape is intentionally stable: table rows still expose `id`, `status`, `createdAt`, `amount`, `customer`, and `_actions`.

## Retirement note

`OrderSummaryPage` and `OrderSummaryRow` are not retired globally. They are still valid for order-specific demonstration/query screens, but they are no longer the canonical generic CRUD bridge preview contract.

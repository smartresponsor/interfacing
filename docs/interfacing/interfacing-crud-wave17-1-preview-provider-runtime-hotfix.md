# Interfacing CRUD wave17.1 preview provider runtime hotfix

This hotfix closes a runtime signature drift introduced during the neutral CRUD preview DTO migration.

## Fixed

`CrudWorkbenchPreviewProviderInterface::provide()` returns `Contract\Crud\CrudPreviewPage`.

`Service\Interfacing\Crud\CrudWorkbenchPreviewProviderChain::provide()` now uses the same return type and imports `CrudPreviewPage` instead of the legacy order-specific `OrderSummaryPage`.

## Boundary

The generic CRUD workbench preview provider chain remains Interfacing-owned and neutral. Order-specific `OrderSummaryPage` is still allowed only for dedicated order summary screens, not for generic CRUD preview providers.

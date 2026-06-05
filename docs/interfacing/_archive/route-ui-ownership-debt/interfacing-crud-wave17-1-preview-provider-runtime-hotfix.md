# Interfacing CRUD wave17.1 preview provider runtime hotfix

This hotfix closes a runtime signature drift introduced during the neutral CRUD preview DTO migration.

## Fixed

`InterfaceCrudWorkbenchPreviewProviderInterface::provide()` returns `Contract\Crud\InterfaceCrudPreviewPage`.

`Service\Interfacing\Crud\InterfaceCrudWorkbenchPreviewProviderChainService::provide()` now uses the same return type and imports `InterfaceCrudPreviewPage` instead of the legacy order-specific `InterfaceOrderSummaryPage`.

## Boundary

The generic CRUD workbench preview provider chain remains Interfacing-owned and neutral. Order-specific `InterfaceOrderSummaryPage` is still allowed only for dedicated order summary screens, not for generic CRUD preview providers.

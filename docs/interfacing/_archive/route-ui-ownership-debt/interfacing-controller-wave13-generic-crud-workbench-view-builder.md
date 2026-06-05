# Interfacing Wave13 — Generic CRUD Workbench View Builder

Wave13 continues the controller-thinning sequence by extracting generic CRUD bridge page assembly from `InterfaceGenericCrudWorkbenchController`.

## Boundary decision

`InterfaceGenericCrudWorkbenchController` remains the owner of the broad catch-all CRUD bridge routes registered in `config/routes/zz_interfacing_crud_bridge.yaml`.

The controller no longer owns route-context resolution, screen-context resolution, filter extraction, demo-backed sample page construction, or `InterfaceCrudWorkbenchView` assembly. Those responsibilities now belong to `Service/Interfacing/View/InterfaceGenericCrudWorkbenchViewBuilderService.php` behind `ServiceInterface/Interfacing/View/InterfaceGenericCrudWorkbenchViewBuilderInterface.php`.

## Why

The generic bridge is intentionally route-compatible and demo-backed while owning components progressively publish concrete CRUD handlers. Keeping sample data and route grammar inside the controller made the controller a second service layer. This wave restores the Symfony-oriented boundary: controller owns HTTP entrypoint and rendering; service owns view payload assembly.

## Compatibility

Public routes, route names, Twig template, and rendered payload shape are unchanged.

## Follow-up

A later wave can replace the demo-backed `InterfaceOrderSummaryPage` construction with a provider contract so owning components can contribute resource-specific preview rows without changing bridge routes.

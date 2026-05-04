# Interfacing Wave12 — CRUD Explorer view-builder extraction

Wave12 continues the thin-controller cleanup started in waves 10 and 11.

## Canonical decision

`CrudExplorerController` owns HTTP routes, response type, and rendering only.

CRUD Explorer payload assembly now belongs to:

- `Service/Interfacing/View/CrudExplorerViewBuilder.php`
- `ServiceInterface/Interfacing/View/CrudExplorerViewBuilderInterface.php`

## Routes preserved

Wave12 intentionally keeps the public route surface unchanged:

- `/interfacing/crud/explorer`
- `/interfacing/crud/explorer/links.json`
- `/interfacing/crud/explorer/route-expectations.json`
- `/interfacing/crud/explorer/operations.json`

## Boundary

The view builder may depend on CRUD resource providers and Symfony router inspection because it owns page/payload assembly.

The controller must not own sorting, grouping, route expectation rows, operation summary rows, or JSON schema payload construction.

## Follow-up candidates

Do not split the builder further unless it becomes overloaded beyond CRUD Explorer. The next practical controller cleanup target is `GenericCrudWorkbenchController`.

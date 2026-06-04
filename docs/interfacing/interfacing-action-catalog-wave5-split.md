# Interfacing action catalog / registry split — wave5

Wave5 closes the vocabulary drift around action catalogs without deleting runtime code.

## Canonical decision

`Catalog/InterfaceActionEndpointCatalogInterface` is the canonical contract for the legacy/root action endpoint catalog used by bridge code and simple doctor reports.

It describes endpoints that expose:

- `id(): InterfaceActionId`
- `handle(InterfaceActionRequest $request): InterfaceActionResult`

This is intentionally different from the modern action runner endpoint contract in `Action/`, where endpoints run with array input and `InterfaceActionRuntimeInterface`.

## Boundaries

- `Catalog/InterfaceActionEndpointCatalogInterface` — action endpoint catalog for root/bridge endpoints.
- `Action/InterfaceActionCatalogInterface` — modern action runner catalog using `InterfaceActionIdInterface` and `InterfaceActionRuntimeInterface`.
- `Registry/InterfaceActionCatalogInterface` — screen-scoped action registry using `screenId + actionId` and registry endpoints.

These contracts must not be merged mechanically because they model different payloads and execution boundaries.

## Compatibility

The root `InterfaceActionCatalogInterface` now extends the canonical `Catalog/InterfaceActionEndpointCatalogInterface` and is retained only for compatibility. New consumers must import the canonical catalog contract.

## Follow-up candidates

- Migrate remaining consumers away from root `InterfaceActionCatalogInterface`.
- Decide whether the root `InterfaceActionEndpointInterface` should move under `Catalog/` or remain as a compatibility endpoint contract.
- Review `Service/Interfacing/InterfaceActionCatalogService.php` against `Service/Interfacing/Action/InterfaceActionCatalogService.php` after all callers are classified.

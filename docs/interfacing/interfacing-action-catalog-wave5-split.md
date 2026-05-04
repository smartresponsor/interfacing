# Interfacing action catalog / registry split — wave5

Wave5 closes the vocabulary drift around action catalogs without deleting runtime code.

## Canonical decision

`Catalog/ActionEndpointCatalogInterface` is the canonical contract for the legacy/root action endpoint catalog used by bridge code and simple doctor reports.

It describes endpoints that expose:

- `id(): ActionId`
- `handle(ActionRequest $request): ActionResult`

This is intentionally different from the modern action runner endpoint contract in `Action/`, where endpoints run with array input and `ActionRuntimeInterface`.

## Boundaries

- `Catalog/ActionEndpointCatalogInterface` — action endpoint catalog for root/bridge endpoints.
- `Action/ActionCatalogInterface` — modern action runner catalog using `ActionIdInterface` and `ActionRuntimeInterface`.
- `Registry/ActionCatalogInterface` — screen-scoped action registry using `screenId + actionId` and registry endpoints.

These contracts must not be merged mechanically because they model different payloads and execution boundaries.

## Compatibility

The root `ActionCatalogInterface` now extends the canonical `Catalog/ActionEndpointCatalogInterface` and is retained only for compatibility. New consumers must import the canonical catalog contract.

## Follow-up candidates

- Migrate remaining consumers away from root `ActionCatalogInterface`.
- Decide whether the root `ActionEndpointInterface` should move under `Catalog/` or remain as a compatibility endpoint contract.
- Review `Service/Interfacing/ActionCatalog.php` against `Service/Interfacing/Action/ActionCatalog.php` after all callers are classified.

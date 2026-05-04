# Interfacing action endpoint contract split — wave6

Wave6 closes the remaining root-level `ActionEndpointInterface` drift after the wave5 action-catalog split.

## Canonical decision

`Catalog/ActionEndpointInterface` is the canonical contract for bridge/simple action endpoints that expose:

- `id(): ActionId`
- `handle(ActionRequest $request): ActionResult`

This endpoint model is cataloged by `Catalog/ActionEndpointCatalogInterface` and is intentionally separate from the modern action runner and screen-scoped registry models.

## Boundaries

- `Catalog/ActionEndpointInterface` — bridge/simple endpoint contract using `ActionRequest` and `ActionResult` from `Contract/Action`.
- `Catalog/ActionEndpointCatalogInterface` — catalog for the bridge/simple endpoint set.
- `Action/ActionEndpointInterface` — modern action runner endpoint using array input and `ActionRuntimeInterface`.
- `Registry/ActionEndpointInterface` — screen-scoped runtime/registry endpoint using `screenId + actionId`.

## Compatibility

The root `ActionEndpointInterface` is retained as a deprecated compatibility alias extending `Catalog/ActionEndpointInterface`. New code must import the canonical catalog endpoint contract.

## Migrated in this wave

- `Service/Interfacing/ActionCatalog.php`
- `Service/Interfacing/Action/CategoryListEndpoint.php`
- `Service/Interfacing/Action/CategoryOpenEndpoint.php`
- `Service/Interfacing/Action/CategorySaveEndpoint.php`
- `ServiceInterface/Interfacing/Catalog/ActionEndpointCatalogInterface.php`

## Follow-up candidates

- Migrate any remaining bridge/simple endpoint implementations from the root alias to `Catalog/ActionEndpointInterface`.
- Keep `Action/ActionEndpointInterface` and `Registry/ActionEndpointInterface` separate unless their payload models are explicitly unified.
- Remove the deprecated root alias only after import scans prove there are no consumers left.

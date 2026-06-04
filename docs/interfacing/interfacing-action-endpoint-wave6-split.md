# Interfacing action endpoint contract split — wave6

Wave6 closes the remaining root-level `InterfaceActionEndpointInterface` drift after the wave5 action-catalog split.

## Canonical decision

`Catalog/InterfaceActionEndpointInterface` is the canonical contract for bridge/simple action endpoints that expose:

- `id(): InterfaceActionId`
- `handle(InterfaceActionRequest $request): InterfaceActionResult`

This endpoint model is cataloged by `Catalog/InterfaceActionEndpointCatalogInterface` and is intentionally separate from the modern action runner and screen-scoped registry models.

## Boundaries

- `Catalog/InterfaceActionEndpointInterface` — bridge/simple endpoint contract using `InterfaceActionRequest` and `InterfaceActionResult` from `Contract/Action`.
- `Catalog/InterfaceActionEndpointCatalogInterface` — catalog for the bridge/simple endpoint set.
- `Action/InterfaceActionEndpointInterface` — modern action runner endpoint using array input and `InterfaceActionRuntimeInterface`.
- `Registry/InterfaceActionEndpointInterface` — screen-scoped runtime/registry endpoint using `screenId + actionId`.

## Compatibility

The root `InterfaceActionEndpointInterface` is retained as a deprecated compatibility alias extending `Catalog/InterfaceActionEndpointInterface`. New code must import the canonical catalog endpoint contract.

## Migrated in this wave

- `Service/Interfacing/InterfaceActionCatalogService.php`
- `Service/Interfacing/Action/InterfaceCategoryListEndpointService.php`
- `Service/Interfacing/Action/InterfaceCategoryOpenEndpointService.php`
- `Service/Interfacing/Action/InterfaceCategorySaveEndpointService.php`
- `ServiceInterface/Interfacing/Catalog/InterfaceActionEndpointCatalogInterface.php`

## Follow-up candidates

- Migrate any remaining bridge/simple endpoint implementations from the root alias to `Catalog/InterfaceActionEndpointInterface`.
- Keep `Action/InterfaceActionEndpointInterface` and `Registry/InterfaceActionEndpointInterface` separate unless their payload models are explicitly unified.
- Remove the deprecated root alias only after import scans prove there are no consumers left.

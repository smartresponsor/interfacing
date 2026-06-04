# Source catalog and runtime contract canon

Interfacing is already scoped as `App\Interfacing\...`, so source classes must be classified by Symfony-oriented layer and class responsibility rather than by transitional root aliases.

## Catalog services

Visible/spec catalogs live under the typed catalog service bucket:

- `src/Catalog/InterfaceActionEndpointCatalog.php`
- `src/Catalog/InterfaceScreenSpecCatalog.php`

The old root service files are retired:

- `src/Service/InterfaceActionCatalogService.php`
- `src/Service/InterfaceScreenCatalogService.php`

Registry classes remain separate only when they represent screen-scoped or compiler-fed runtime registries. Do not collapse registry contracts into the visible/spec catalog contract unless the behavior is identical.

## Runtime action DTOs

Runtime action request/result DTOs are contracts, not service interfaces. They live under:

- `src/Contract/Runtime/InterfaceActionRequest.php`
- `src/Contract/Runtime/InterfaceActionResult.php`

The old `src/ServiceInterface/Runtime/InterfaceActionRequest.php` and `src/ServiceInterface/Runtime/InterfaceActionResult.php` files are retired.

## Retired root ServiceInterface aliases

The following root aliases must not return:

- `src/ServiceInterface/InterfaceActionEndpointInterface.php`
- `src/ServiceInterface/InterfaceBaseContextProviderInterface.php`
- `src/ServiceInterface/InterfaceScreenCatalogInterface.php`
- `src/ServiceInterface/InterfaceScreenProviderInterface.php`

Use the typed contracts instead:

- `ServiceInterface/Catalog/InterfaceActionEndpointInterface`
- `ServiceInterface/Context/InterfaceBaseContextProviderInterface`
- `ServiceInterface/Catalog/InterfaceScreenSpecCatalogInterface`
- `ServiceInterface/Provider/InterfaceScreenProviderInterface` or `ServiceInterface/Runtime/InterfaceScreenProviderInterface`, depending on whether the provider publishes screen specs or live-component runtime mappings.

## Gate

`composer canon:interfacing` must fail if root service catalogs, runtime DTOs inside `ServiceInterface`, or the retired root aliases return.

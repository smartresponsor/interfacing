# Interfacing CRUD wave14 — preview provider boundary

Wave14 moves generic CRUD workbench preview rows out of `GenericCrudWorkbenchViewBuilder` and into a provider contract.

## Canonical contract

- `src/ServiceInterface/Interfacing/Crud/CrudWorkbenchPreviewProviderInterface.php`

The contract answers two questions:

- whether a provider supports a `resourcePath`;
- which `OrderSummaryPage` preview rows should feed the generic workbench for that resource.

## Canonical services

- `src/Service/Interfacing/Crud/CrudWorkbenchPreviewProviderChain.php`
- `src/Service/Interfacing/Crud/DefaultCrudWorkbenchPreviewProvider.php`

The chain selects the first tagged provider that supports the current resource path. If none matches, it falls back to `DefaultCrudWorkbenchPreviewProvider` so standalone Interfacing keeps a working preview surface.

## Tag for owning components

Owning components may contribute preview providers by implementing the contract and tagging the service as:

```yaml
- { name: interfacing.crud_workbench_preview_provider }
```

This preserves the catch-all route boundary: owning components can publish preview data without changing `GenericCrudWorkbenchController`, `GenericCrudWorkbenchViewBuilder`, or route declarations.

## Boundary rule

`GenericCrudWorkbenchViewBuilder` may assemble route context, filters, screen context, and workbench view payloads. It must not own component-specific sample rows. Preview rows belong to `CrudWorkbenchPreviewProviderInterface` implementations.

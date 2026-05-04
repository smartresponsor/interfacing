# Interfacing ServiceInterface manifest

This tree contains Symfony-oriented service contracts for the Interfacing component. Net-new contracts should use responsibility folders rather than root-level donor files.

## Canonical folders

- `Provider/` — contribution providers that feed catalogs and registries.
- `Context/` — request/base/screen context contracts.
- `Screen/` — screen orchestration contracts that are not provider contributions.
- `Action/` — action endpoint, registry, dispatcher, and runner contracts.
- `Registry/` — descriptor registries and registry-specific catalogs.
- `Runtime/` — runtime execution/component-map contracts.
- `Shell/` — shell chrome, panels, footer, navigation, and layout-preview contracts.
- `Access/` and `Security/` — request-aware and screen-aware access/security contracts until a later access-facade decision.
- `Localization/` — Interfacing-owned template selector/context boundary; host apps may bind Localizing implementations externally.

## Deprecated root-level aliases

The following root-level interfaces are compatibility aliases and must not be used by new code:

- `ScreenProviderInterface`
- `BaseContextProviderInterface`

Do not introduce additional root-level service contracts unless they are marker interfaces or are explicitly documented as transitional.

## Wave4 screen catalog / registry split

- Canonical UI screen-spec catalog: `Catalog/ScreenSpecCatalogInterface.php`.
- Deprecated compatibility interface: root `ScreenCatalogInterface.php`.
- Descriptor registry and runtime screen mapping are intentionally separate contracts.


## Wave5 action catalog / registry split

- Canonical legacy/root endpoint catalog: `Catalog/ActionEndpointCatalogInterface.php`.
- Deprecated compatibility interface: root `ActionCatalogInterface.php`.
- Modern action runner catalog remains `Action/ActionCatalogInterface.php`.
- Screen-scoped runtime/registry catalog remains `Registry/ActionCatalogInterface.php`.

## Wave6 action endpoint contract split

- Canonical bridge/simple endpoint contract: `Catalog/ActionEndpointInterface.php`.
- Deprecated compatibility interface: root `ActionEndpointInterface.php`.
- Modern action-runner endpoint remains `Action/ActionEndpointInterface.php`.
- Screen-scoped runtime/registry endpoint remains `Registry/ActionEndpointInterface.php`.

## Wave7 access resolver split

- Canonical request-aware screen/action resolver: `Access/ScreenActionAccessResolverInterface.php`.
- Canonical legacy role-list resolver: `Access/RoleAccessResolverInterface.php`.
- Canonical screen-spec resolver: `Security/ScreenAccessResolverInterface.php`.
- Canonical shell capability resolver: `Shell/CapabilityAccessResolverInterface.php`.
- Root/transitional `AccessResolverInterface` names remain compatibility aliases only.


## Wave8 implementation binding note

DI aliases for wave7 canonical access contracts now point to type-identifiable implementation names:

- `Access/ScreenActionAccessResolverInterface` -> `Service/Interfacing/Access/SymfonyScreenActionAccessResolver`.
- `Access/RoleAccessResolverInterface` -> `Service/Interfacing/Access/SymfonyRoleAccessResolver`.
- `Security/ScreenAccessResolverInterface` -> `Service/Interfacing/Security/SymfonyScreenAccessResolver`.
- `Shell/CapabilityAccessResolverInterface` -> `Service/Interfacing/Shell/SymfonyCapabilityAccessResolver`.

## Wave10 workspace view-builder contract

Canonical workspace page context contract:

- `View/InterfacingWorkspaceViewBuilderInterface.php`

This contract owns Interfacing workspace page context assembly for the current dashboard/workbench pages. New controllers should depend on this contract or narrower page-specific builders rather than injecting ecommerce providers directly.

## Wave12 CRUD explorer view-builder contract

Canonical CRUD Explorer view contract:

- `View/CrudExplorerViewBuilderInterface.php`

This contract owns CRUD Explorer page context and JSON payload assembly. Controllers should consume this interface instead of injecting `CrudResourceExplorerProviderInterface` and `RouterInterface` directly.

## Wave13 generic CRUD workbench view-builder contract

Canonical generic CRUD workbench contract:

- `View/GenericCrudWorkbenchViewBuilderInterface.php`

This contract owns catch-all CRUD bridge page context assembly. `GenericCrudWorkbenchController` should depend on this interface and remain responsible only for route ownership and rendering.

## Wave14 CRUD workbench preview provider contract

Canonical generic CRUD preview data contract:

- `Crud/CrudWorkbenchPreviewProviderInterface.php`

Owning components can contribute resource-specific preview rows by implementing this contract and tagging the service with `interfacing.crud_workbench_preview_provider`.

## Wave 15 — Neutral CRUD preview provider contract

`Crud/CrudWorkbenchPreviewProviderInterface.php` now returns `Contract/Crud/CrudPreviewPage`. Component-owned preview providers must map their own read/query models into Interfacing neutral preview DTOs.


## Wave 16 — CRUD descriptor contribution contract

`CrudResourceDescriptorContributionInterface` is the canonical contribution surface for generic CRUD resource metadata. `CrudResourceContributionInterface` is retained as a deprecated compatibility alias.

## Wave 17 — CRUD operation grammar provider contract

Canonical CRUD route grammar provider:

- `Crud/CrudOperationGrammarProviderInterface.php`

This contract owns the operation vocabulary for generic CRUD bridge routes. Consumers should not duplicate `app_crud_*` route-name arrays or grammar literals.

- Wave18: `README.php` marker was retired and replaced by `README.md` to avoid PSR-4 class scanning noise.

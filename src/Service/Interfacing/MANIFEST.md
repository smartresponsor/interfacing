# Interfacing Manifest

Interfacing service donor family. Keep runtime alive; evacuate touched code gradually.


## Wave8 access implementation dedup

Canonical Symfony-backed access implementations now use type-identifiable names:

- `Access/SymfonyScreenActionAccessResolver.php` for request-aware screen/action decisions.
- `Access/SymfonyRoleAccessResolver.php` for legacy role-list checks.
- `Security/SymfonyScreenAccessResolver.php` for ScreenSpec checks.
- `Shell/SymfonyCapabilityAccessResolver.php` for shell capability checks.

Generic `SymfonyAccessResolver` and `AllowAllAccessResolver` class names remain compatibility wrappers only.

## Wave10 controller view-builder extraction

Workspace page payload assembly moved from `Presentation/Controller/Interfacing/InterfacingController.php` to `Service/Interfacing/View/InterfacingWorkspaceViewBuilder.php`.

Controllers should own HTTP routing and rendering orchestration only; ecommerce/workbench dashboard context assembly belongs to service-layer view builders.

## Wave12 CRUD explorer view-builder extraction

CRUD Explorer payload assembly moved from `Presentation/Controller/Interfacing/CrudExplorerController.php` to `Service/Interfacing/View/CrudExplorerViewBuilder.php`.

`CrudExplorerController` should remain a thin HTTP owner for the four public CRUD Explorer endpoints. Route grammar, operation summaries, link payloads, and route expectation payloads belong to the view-builder service layer.

## Wave13 generic CRUD workbench view-builder extraction

Generic CRUD bridge workbench payload assembly moved from `Presentation/Controller/Interfacing/GenericCrudWorkbenchController.php` to `Service/Interfacing/View/GenericCrudWorkbenchViewBuilder.php`.

The catch-all CRUD bridge should keep routes stable while delegating route-context, screen-context, filters, sample page construction, and workbench view assembly into the service layer.

## Wave14 CRUD workbench preview provider

Generic CRUD workbench preview rows moved from `Service/Interfacing/View/GenericCrudWorkbenchViewBuilder.php` into CRUD provider services:

- `Crud/CrudWorkbenchPreviewProviderChain.php`
- `Crud/DefaultCrudWorkbenchPreviewProvider.php`

The view builder now consumes `ServiceInterface/Interfacing/Crud/CrudWorkbenchPreviewProviderInterface` and remains responsible only for workbench context assembly.

## Wave 15 — Neutral CRUD preview DTO boundary

`Crud/DefaultCrudWorkbenchPreviewProvider.php` now returns neutral `Contract/Crud/CrudPreviewPage` data. The generic workbench renderer consumes `CrudWorkbenchFactory::buildCrudPreviewView()` and no longer treats `OrderSummaryPage` as the generic bridge preview model.


## Wave 16 — CRUD descriptor normalization

`CrudResourceExplorerProvider` now normalizes canonical `CrudResourceDescriptorInterface` objects into route-aware view link sets. Contribution classes publish URL-free descriptors through the shared abstract contribution factory.

## Wave 17 — CRUD operation grammar provider

`Crud/DefaultCrudOperationGrammarProvider.php` is the canonical provider for the generic CRUD bridge operation grammar. `CrudExplorerViewBuilder` and `CrudResourceExplorerProvider` consume it instead of duplicating route-name and pattern arrays.

- Wave18: `README.php` marker was retired and replaced by `README.md` to avoid PSR-4 class scanning noise.

# Wave 10 Delete List

Deleted moved donor files:
- src/Domain/Interfacing/Model/Form/FormFieldSpec.php
- src/Domain/Interfacing/Model/Form/FormSpec.php
- src/Domain/Interfacing/Model/Form/FormSubmitResult.php
- src/DomainInterface/Interfacing/Model/Form/FormFieldSpecInterface.php
- src/DomainInterface/Interfacing/Model/Form/FormSpecInterface.php
- src/DomainInterface/Interfacing/Model/Form/FormSubmitResultInterface.php
- src/Domain/Interfacing/Model/Metric/MetricCard.php
- src/Domain/Interfacing/Model/Metric/MetricDatum.php
- src/Domain/Interfacing/Model/Metric/MetricQuery.php
- src/Domain/Interfacing/Model/Metric/MetricSpec.php
- src/DomainInterface/Interfacing/Model/Metric/MetricCardInterface.php
- src/DomainInterface/Interfacing/Model/Metric/MetricDatumInterface.php
- src/DomainInterface/Interfacing/Model/Metric/MetricQueryInterface.php
- src/DomainInterface/Interfacing/Model/Metric/MetricSpecInterface.php
- src/Domain/Interfacing/Model/Wizard/WizardProgress.php
- src/Domain/Interfacing/Model/Wizard/WizardSpec.php
- src/Domain/Interfacing/Model/Wizard/WizardStepSpec.php
- src/DomainInterface/Interfacing/Model/Wizard/WizardProgressInterface.php
- src/DomainInterface/Interfacing/Model/Wizard/WizardSpecInterface.php
- src/DomainInterface/Interfacing/Model/Wizard/WizardStepSpecInterface.php
- src/Domain/Interfacing/Spec/FormFieldSpec.php
- src/Domain/Interfacing/Spec/FormSpec.php
- src/Domain/Interfacing/Spec/MetricSpec.php
- src/Domain/Interfacing/Spec/WizardStepSpec.php
- src/Domain/Interfacing/Spec/WizardSpec.php

# Wave 11 Delete List

Deleted moved donor files:
- src/Domain/Interfacing/Model/BulkAction/BulkActionResult.php
- src/Domain/Interfacing/Model/BulkAction/BulkActionSpec.php
- src/DomainInterface/Interfacing/Model/BulkAction/BulkActionResultInterface.php
- src/DomainInterface/Interfacing/Model/BulkAction/BulkActionSpecInterface.php
- src/Domain/Interfacing/Model/DataGrid/DataGridColumnSpec.php
- src/Domain/Interfacing/Model/DataGrid/DataGridQuery.php
- src/Domain/Interfacing/Model/DataGrid/DataGridResult.php
- src/Domain/Interfacing/Model/DataGrid/DataGridRow.php
- src/DomainInterface/Interfacing/Model/DataGrid/DataGridColumnSpecInterface.php
- src/DomainInterface/Interfacing/Model/DataGrid/DataGridQueryInterface.php
- src/DomainInterface/Interfacing/Model/DataGrid/DataGridResultInterface.php
- src/DomainInterface/Interfacing/Model/DataGrid/DataGridRowInterface.php
- src/Domain/Interfacing/Model/Shell/ShellNavGroup.php
- src/Domain/Interfacing/Model/Shell/ShellNavItem.php
- src/Domain/Interfacing/Model/Shell/ShellView.php
- src/DomainInterface/Interfacing/Model/Shell/ShellNavGroupInterface.php
- src/DomainInterface/Interfacing/Model/Shell/ShellNavItemInterface.php
- src/DomainInterface/Interfacing/Model/Shell/ShellViewInterface.php
- src/Domain/Interfacing/Query/BillingMeterPage.php
- src/Domain/Interfacing/Query/BillingMeterRow.php
- src/Domain/Interfacing/Query/OrderSummaryPage.php
- src/Domain/Interfacing/Query/OrderSummaryRow.php
- src/DomainInterface/Interfacing/Query/BillingMeterQueryInterface.php
- src/DomainInterface/Interfacing/Query/OrderSummaryQueryInterface.php

- src/Domain/Interfacing/Attribute/AsInterfacingAction.php
- src/Domain/Interfacing/Attribute/AsInterfacingScreen.php
- src/Domain/Interfacing/Demo/DemoUserProfileInput.php
- src/Domain/Interfacing/Model/CategoryFormModel.php
- src/Domain/Interfacing/Model/CategoryItemView.php
- src/Domain/Interfacing/Model/TelemetryEvent.php
- src/Domain/Interfacing/Model/UiState.php
- src/Domain/Interfacing/Model/WidgetId.php
- src/Domain/Interfacing/Action/ActionId.php
- src/DomainInterface/Interfacing/Model/UiStateInterface.php
- src/DomainInterface/Interfacing/Model/WidgetIdInterface.php

Wave 13 deleted donor files:
- src/Domain/Interfacing/Layout/LayoutId.php
- src/Domain/Interfacing/Layout/LayoutSpec.php
- src/Domain/Interfacing/Screen/ScreenId.php
- src/Domain/Interfacing/Screen/ScreenSpec.php
- src/Domain/Interfacing/Spec/LayoutScreenSpec.php
- src/DomainInterface/Interfacing/Layout/LayoutIdInterface.php
- src/DomainInterface/Interfacing/Layout/LayoutSpecInterface.php
- src/DomainInterface/Interfacing/Layout/LayoutProviderInterface.php
- src/DomainInterface/Interfacing/Screen/ScreenIdInterface.php
- src/DomainInterface/Interfacing/Screen/ScreenSpecInterface.php
- src/DomainInterface/Interfacing/Screen/ScreenProviderInterface.php
- src/DomainInterface/Interfacing/Value/ScreenIdInterface.php
- src/Service/Interfacing/Access/AllowAllAccessResolver.php

## Wave 14
- removed src/Domain and src/DomainInterface after final consumer cutover
- cut remaining action/context/security/telemetry consumer references to ServiceInterface/Contract layers
- switched old screen/nav/action paths to contract/runtime layers

## Boundary audit wave retirement candidates

Retirement candidates identified in the current Interfacing slice. These are not removed by overlay application; review and delete explicitly in a cleanup wave.

- pack/src/ — retired package-prototype namespace `SmartResponsor\Interfacing\...`; conflicts with active `App\Interfacing\...` source boundary.
- pack/templates/ — prototype template root; migrate unique templates to `template/` before removal.
- CrudRouteContext.php — root donor; canonical file already exists at `src/Contract/Crud/CrudRouteContext.php`.
- CrudWorkbenchFactory.php — root donor; canonical file already exists at `src/Service/Interfacing/Crud/CrudWorkbenchFactory.php`.
- base.html.twig — root donor; canonical Interfacing Twig root is `template/`.
- templates/base.html.twig — duplicate template root candidate; prefer `template/base.html.twig` or explicit host mapping.
- crud/ — root template donor candidate; prefer `template/interfacing/...` for active Twig surfaces.
- src/Integration/Symfony/InterfacingBundle.php — duplicate bundle entrypoint candidate; active bundle is `src/InterfacingBundle.php`.
- src/Integration/Symfony/DependencyInjection/InterfacingExtension.php — duplicate extension candidate; active extension is `src/DependencyInjection/InterfacingExtension.php`.

## Wave 2 closed retirements

Explicitly retired from the cumulative snapshot because canonical active equivalents already exist:

- `src/Integration/Symfony/InterfacingBundle.php` -> duplicate bundle entrypoint; use `src/InterfacingBundle.php`.
- `src/Integration/Symfony/DependencyInjection/InterfacingExtension.php` -> duplicate DI extension; use `src/DependencyInjection/InterfacingExtension.php`.
- `CrudRouteContext.php` -> root donor; use `src/Contract/Crud/CrudRouteContext.php`.
- `CrudWorkbenchFactory.php` -> root donor; use `src/Service/Interfacing/Crud/CrudWorkbenchFactory.php`.
- `base.html.twig` -> root donor; use `template/base.html.twig`.
- `crud/screen.html.twig` -> root donor; use `template/interfacing/crud/screen.html.twig`.
- `crud/workbench_base.html.twig` -> root donor; use `template/interfacing/crud/workbench_base.html.twig`.
- `templates/base.html.twig` -> duplicate donor; use `template/base.html.twig`.

## Wave3 service-interface dedup notes

No files are deleted in wave3. The following aliases are now explicitly transitional and are candidates for a later explicit-retirement wave after imports are migrated:

- `src/ServiceInterface/Interfacing/ScreenProviderInterface.php`
- `src/ServiceInterface/Interfacing/Screen/ScreenProviderInterface.php`
- `src/ServiceInterface/Interfacing/BaseContextProviderInterface.php`

## Wave4 follow-up candidates

- `src/ServiceInterface/Interfacing/ScreenCatalogInterface.php` — deprecated compatibility interface; retire after all consumers use `Catalog/ScreenSpecCatalogInterface`.
- `src/ServiceInterface/Interfacing/Screen/ScreenCatalogInterface.php` — value-object-id variant; keep only if a concrete use case remains.
- `src/Service/Interfacing/Screen/ScreenCatalog.php` — duplicate screen-spec catalog implementation; compare against canonical `Service/Interfacing/ScreenCatalog.php` before retirement.
- `src/ServiceInterface/Interfacing/Registry/ScreenRegistryInterface.php` — spec-based registry name may be misleading; rename or retire after consumer migration.


## Wave5 follow-up candidates

- `src/ServiceInterface/Interfacing/ActionCatalogInterface.php` — deprecated compatibility interface; retire after consumers use `Catalog/ActionEndpointCatalogInterface`.
- `src/ServiceInterface/Interfacing/ActionEndpointInterface.php` — root endpoint contract; decide whether to move under `Catalog/` after endpoint consumers are classified.
- `src/Service/Interfacing/ActionCatalog.php` — legacy/root endpoint catalog; compare against `Service/Interfacing/Action/ActionCatalog.php` after runtime and bridge consumers are separated.
- `src/ServiceInterface/Interfacing/Registry/ActionCatalogInterface.php` — keep for screen-scoped registry/runtime use; do not merge into endpoint catalog.

## Wave6 — action endpoint compatibility alias

Retain for now, but treat as deprecated after the canonical endpoint split:

- `src/ServiceInterface/Interfacing/ActionEndpointInterface.php`

Canonical replacement:

- `src/ServiceInterface/Interfacing/Catalog/ActionEndpointInterface.php`

## Wave7 follow-up candidates

Retain for compatibility in wave7, then retire after all consumers and host services use canonical contracts:

- `src/ServiceInterface/Interfacing/Access/AccessResolverInterface.php` — deprecated alias for `Access/ScreenActionAccessResolverInterface.php`.
- `src/ServiceInterface/Interfacing/AccessResolverInterface.php` — deprecated alias for `Access/RoleAccessResolverInterface.php`.
- `src/ServiceInterface/Interfacing/Security/AccessResolverInterface.php` — deprecated alias for `Security/ScreenAccessResolverInterface.php`.
- `src/ServiceInterface/Interfacing/Shell/AccessResolverInterface.php` — deprecated alias for `Shell/CapabilityAccessResolverInterface.php`.


## Wave8 follow-up candidates

Retain for compatibility after wave8, then retire after host references and imports move to canonical implementation names:

- `src/Service/Interfacing/Access/SymfonyAccessResolver.php` — wrapper for `Access/SymfonyScreenActionAccessResolver.php`.
- `src/Service/Interfacing/SymfonyAccessResolver.php` — wrapper for `Access/SymfonyRoleAccessResolver.php`.
- `src/Service/Interfacing/Security/SymfonyAccessResolver.php` — wrapper for `Security/SymfonyScreenAccessResolver.php`.
- `src/Service/Interfacing/Shell/SymfonyAccessResolver.php` — wrapper for `Shell/SymfonyCapabilityAccessResolver.php`.
- `src/Service/Interfacing/Security/AllowAllAccessResolver.php` — wrapper for `Security/AllowAllScreenAccessResolver.php`.
- `src/Service/Interfacing/Shell/AllowAllAccessResolver.php` — wrapper for `Shell/AllowAllCapabilityAccessResolver.php`.

## Wave 9 route/controller retirement candidates

- `config/routes.yaml` active controller imports — not used by the standalone `Kernel`; keep only as host compatibility note.
- Explicit `config/routes/interfacing.yaml` route declarations for billing/order/screen — retired in favor of attribute imports.
- Duplicate `/interfacing` ownership in `config/routes/interfacing_layout.yaml` — retired; layout routes are now scoped under `/interfacing/layout`.

## Wave10 controller decomposition note

No files are deleted in wave10. The old direct ecommerce-provider injections inside `InterfacingController` are retired by code change, not by file removal.

Next candidates:

- Move dynamic `/interfacing/{id}` screen payload assembly to `ScreenViewBuilderInterface` once HTTP exception mapping is aligned.
- Split `InterfacingWorkspaceViewBuilder` into narrower page-family builders if it grows beyond dashboard/workbench aggregation responsibility.

## Wave 11 follow-up candidates

- Review `InterfacingController` after dynamic route extraction; it should now remain a static workspace/page controller only.
- Review legacy route `/interfacing/screen/{id}` for eventual retirement once external consumers use `/interfacing/{id}` or the catalog route.

## Wave 12 controller decomposition note

No files are deleted in wave12. The old direct CRUD provider/router orchestration inside `CrudExplorerController` is retired by code change, not by file removal.

Next candidates:

- Split `CrudExplorerViewBuilder` into narrower `CrudLinkPayloadBuilder`, `CrudRouteExpectationBuilder`, and `CrudOperationLaunchpadBuilder` only if it grows beyond CRUD Explorer responsibility.
- Review `GenericCrudWorkbenchController` for similar route grammar/payload extraction after CRUD Explorer stabilizes.


## Wave13 follow-up candidates

- Replace demo-backed sample row construction in `GenericCrudWorkbenchViewBuilder` with resource-specific provider contributions once owning CRUD components publish concrete preview providers.
- Keep `GenericCrudWorkbenchController` thin; do not reintroduce route-context or workbench payload assembly into the controller.

## Wave14 follow-up candidates

No files are deleted in wave14. The old inline sample-page construction inside `GenericCrudWorkbenchViewBuilder` is retired by code change, not file removal.

Next candidates:

- Add component-owned `CrudWorkbenchPreviewProviderInterface` implementations for high-value resources once their repositories expose preview/query contracts.
- Consider splitting `OrderSummaryPage`-based preview into a generic table preview DTO if non-order resources need a neutral payload model.


## Wave 15 follow-up candidates

- Audit external component preview providers to ensure they return `CrudPreviewPage` rather than order-specific read models.
- Keep `OrderSummaryPage` only for order-specific screens; do not use it as the generic CRUD bridge preview contract.


## Boundary wave16 retirement candidates

- `App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface` remains a deprecated compatibility alias; new contribution code should implement `CrudResourceDescriptorContributionInterface`.
- Direct construction of `Contract\View\CrudResourceLinkSet` inside contribution classes should be avoided. Contributions should publish `Contract\Crud\CrudResourceDescriptorInterface` instead.

## Wave 17 follow-up candidates

- Hardcoded CRUD operation arrays inside `Contract/View/CrudResourceLinkSet` are retained for compatibility. A later wave can move those view operation arrays behind `CrudOperationGrammarProviderInterface` if the link-set view model should become fully grammar-provider driven.
- Avoid adding new `app_crud_*` route-name arrays in controllers or view builders; route grammar belongs to `CrudOperationGrammarProviderInterface`.
## Wave 17.1 runtime hotfix note

- No new delete candidates.
- Fixed `CrudWorkbenchPreviewProviderChain` return type drift from order-specific `OrderSummaryPage` to neutral `CrudPreviewPage`.

## Wave18 PSR-4 hygiene

Explicit retired PHP marker files after Markdown replacement:

- `src/Service/Interfacing/README.php` → replaced by `src/Service/Interfacing/README.md`
- `src/ServiceInterface/Interfacing/README.php` → replaced by `src/ServiceInterface/Interfacing/README.md`


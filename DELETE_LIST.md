# Wave 10 Delete List

Deleted moved donor files:
- src/Domain/Interfacing/Model/Form/InterfaceFormFieldSpec.php
- src/Domain/Interfacing/Model/Form/InterfaceFormSpec.php
- src/Domain/Interfacing/Model/Form/InterfaceFormSubmitResult.php
- src/DomainInterface/Interfacing/Model/Form/InterfaceFormFieldSpecInterface.php
- src/DomainInterface/Interfacing/Model/Form/InterfaceFormSpecInterface.php
- src/DomainInterface/Interfacing/Model/Form/InterfaceFormSubmitResultInterface.php
- src/Domain/Interfacing/Model/Metric/InterfaceMetricCard.php
- src/Domain/Interfacing/Model/Metric/InterfaceMetricDatum.php
- src/Domain/Interfacing/Model/Metric/InterfaceMetricQuery.php
- src/Domain/Interfacing/Model/Metric/InterfaceMetricSpec.php
- src/DomainInterface/Interfacing/Model/Metric/InterfaceMetricCardInterface.php
- src/DomainInterface/Interfacing/Model/Metric/InterfaceMetricDatumInterface.php
- src/DomainInterface/Interfacing/Model/Metric/InterfaceMetricQueryInterface.php
- src/DomainInterface/Interfacing/Model/Metric/InterfaceMetricSpecInterface.php
- src/Domain/Interfacing/Model/Wizard/InterfaceWizardProgress.php
- src/Domain/Interfacing/Model/Wizard/InterfaceWizardSpec.php
- src/Domain/Interfacing/Model/Wizard/InterfaceWizardStepSpec.php
- src/DomainInterface/Interfacing/Model/Wizard/InterfaceWizardProgressInterface.php
- src/DomainInterface/Interfacing/Model/Wizard/InterfaceWizardSpecInterface.php
- src/DomainInterface/Interfacing/Model/Wizard/InterfaceWizardStepSpecInterface.php
- src/Domain/Interfacing/Spec/InterfaceFormFieldSpec.php
- src/Domain/Interfacing/Spec/InterfaceFormSpec.php
- src/Domain/Interfacing/Spec/InterfaceMetricSpec.php
- src/Domain/Interfacing/Spec/InterfaceWizardStepSpec.php
- src/Domain/Interfacing/Spec/InterfaceWizardSpec.php

# Wave 11 Delete List

Deleted moved donor files:
- src/Domain/Interfacing/Model/BulkAction/InterfaceBulkActionResult.php
- src/Domain/Interfacing/Model/BulkAction/InterfaceBulkActionSpec.php
- src/DomainInterface/Interfacing/Model/BulkAction/InterfaceBulkActionResultInterface.php
- src/DomainInterface/Interfacing/Model/BulkAction/InterfaceBulkActionSpecInterface.php
- src/Domain/Interfacing/Model/DataGrid/InterfaceDataGridColumnSpec.php
- src/Domain/Interfacing/Model/DataGrid/InterfaceDataGridQuery.php
- src/Domain/Interfacing/Model/DataGrid/InterfaceDataGridResult.php
- src/Domain/Interfacing/Model/DataGrid/InterfaceDataGridRow.php
- src/DomainInterface/Interfacing/Model/DataGrid/InterfaceDataGridColumnSpecInterface.php
- src/DomainInterface/Interfacing/Model/DataGrid/InterfaceDataGridQueryInterface.php
- src/DomainInterface/Interfacing/Model/DataGrid/InterfaceDataGridResultInterface.php
- src/DomainInterface/Interfacing/Model/DataGrid/InterfaceDataGridRowInterface.php
- src/Domain/Interfacing/Model/Shell/InterfaceShellNavGroup.php
- src/Domain/Interfacing/Model/Shell/InterfaceShellNavItem.php
- src/Domain/Interfacing/Model/Shell/InterfaceShellView.php
- src/DomainInterface/Interfacing/Model/Shell/InterfaceShellNavGroupInterface.php
- src/DomainInterface/Interfacing/Model/Shell/InterfaceShellNavItemInterface.php
- src/DomainInterface/Interfacing/Model/Shell/InterfaceShellViewInterface.php
- src/Domain/Interfacing/Query/InterfaceBillingMeterPage.php
- src/Domain/Interfacing/Query/InterfaceBillingMeterRow.php
- src/Domain/Interfacing/Query/InterfaceOrderSummaryPage.php
- src/Domain/Interfacing/Query/InterfaceOrderSummaryRow.php
- src/DomainInterface/Interfacing/Query/BillingMeterQueryInterface.php
- src/DomainInterface/Interfacing/Query/OrderSummaryQueryInterface.php

- src/Domain/Interfacing/Attribute/InterfaceAsAction.php
- src/Domain/Interfacing/Attribute/InterfaceAsScreen.php
- src/Domain/Interfacing/Demo/InterfaceDemoUserProfileInput.php
- src/Domain/Interfacing/Model/CategoryFormModel.php
- src/Domain/Interfacing/Model/InterfaceCategoryItemView.php
- src/Domain/Interfacing/Model/InterfaceTelemetryEvent.php
- src/Domain/Interfacing/Model/InterfaceUiState.php
- src/Domain/Interfacing/Model/InterfaceWidgetId.php
- src/Domain/Interfacing/Action/InterfaceActionId.php
- src/DomainInterface/Interfacing/Model/InterfaceUiStateInterface.php
- src/DomainInterface/Interfacing/Model/InterfaceWidgetIdInterface.php

Wave 13 deleted donor files:
- src/Domain/Interfacing/Layout/InterfaceLayoutId.php
- src/Domain/Interfacing/Layout/LayoutSpec.php
- src/Domain/Interfacing/Screen/InterfaceScreenId.php
- src/Domain/Interfacing/Screen/InterfaceScreenSpec.php
- src/Domain/Interfacing/Spec/InterfaceLayoutScreenSpec.php
- src/DomainInterface/Interfacing/Layout/InterfaceLayoutIdInterface.php
- src/DomainInterface/Interfacing/Layout/LayoutSpecInterface.php
- src/DomainInterface/Interfacing/Layout/InterfaceLayoutProviderInterface.php
- src/DomainInterface/Interfacing/Screen/InterfaceScreenIdInterface.php
- src/DomainInterface/Interfacing/Screen/InterfaceScreenSpecInterface.php
- src/DomainInterface/Interfacing/Screen/InterfaceScreenProviderInterface.php
- src/DomainInterface/Interfacing/Value/InterfaceScreenIdInterface.php
- src/Service/Access/AllowAllAccessResolver.php

## Wave 14
- removed src/Domain and src/DomainInterface after final consumer cutover
- cut remaining action/context/security/telemetry consumer references to ServiceInterface/Contract layers
- switched old screen/nav/action paths to contract/runtime layers

## Boundary audit wave retirement candidates

Retirement candidates identified in the current Interfacing slice. These are not removed by overlay application; review and delete explicitly in a cleanup wave.

- pack/src/ — retired package-prototype namespace `SmartResponsor\Interfacing\...`; conflicts with active `App\Interfacing\...` source boundary.
- pack/templates/ — prototype template root; migrate unique templates to `templates/` before removal.
- InterfaceCrudRouteContext.php — root donor; canonical file already exists at `src/Contract/Crud/InterfaceCrudRouteContext.php`.
- InterfaceCrudWorkbenchFactoryService.php — root donor; canonical file already exists at `src/Factory/Crud/InterfaceCrudWorkbenchFactory.php`.
- base.html.twig — root donor; canonical Interfacing Twig root is `templates/`.
- templates/base.html.twig — duplicate template root candidate; prefer `templates/base.html.twig` or explicit host mapping.
- crud/ — root template donor candidate; prefer `templates/...` for active Twig surfaces.
- src/Integration/Symfony/InterfaceBundle.php — duplicate bundle entrypoint candidate; active bundle is `src/InterfaceBundle.php`.
- src/Integration/Symfony/DependencyInjection/InterfaceExtension.php — duplicate extension candidate; active extension is `src/DependencyInjection/InterfaceExtension.php`.

## Wave 2 closed retirements

Explicitly retired from the cumulative snapshot because canonical active equivalents already exist:

- `src/Integration/Symfony/InterfaceBundle.php` -> duplicate bundle entrypoint; use `src/InterfaceBundle.php`.
- `src/Integration/Symfony/DependencyInjection/InterfaceExtension.php` -> duplicate DI extension; use `src/DependencyInjection/InterfaceExtension.php`.
- `InterfaceCrudRouteContext.php` -> root donor; use `src/Contract/Crud/InterfaceCrudRouteContext.php`.
- `InterfaceCrudWorkbenchFactoryService.php` -> root donor; use `src/Factory/Crud/InterfaceCrudWorkbenchFactory.php`.
- `base.html.twig` -> root donor; use `templates/base.html.twig`.
- `crud/screen.html.twig` -> root donor; use `templates/crud/screen.html.twig`.
- `crud/workbench_base.html.twig` -> root donor; use `templates/crud/workbench_base.html.twig`.
- `templates/base.html.twig` -> duplicate donor; use `templates/base.html.twig`.

## Wave3 service-interface dedup notes

No files are deleted in wave3. The following aliases are now explicitly transitional and are candidates for a later explicit-retirement wave after imports are migrated:

- `src/ServiceInterface/InterfaceScreenProviderInterface.php`
- `src/ServiceInterface/Screen/InterfaceScreenProviderInterface.php`
- `src/ServiceInterface/InterfaceBaseContextProviderInterface.php`

## Wave4 follow-up candidates

- `src/ServiceInterface/InterfaceScreenCatalogInterface.php` — deprecated compatibility interface; retire after all consumers use `Catalog/InterfaceScreenSpecCatalogInterface`.
- `src/ServiceInterface/Screen/InterfaceScreenCatalogInterface.php` — value-object-id variant; keep only if a concrete use case remains.
- `src/Service/Screen/InterfaceScreenCatalogService.php` — duplicate screen-spec catalog implementation; compare against canonical `Service/Interfacing/InterfaceScreenCatalogService.php` before retirement.
- `src/RegistryInterface/AttributeRegistry/InterfaceScreenRegistryInterface.php` — spec-based registry name may be misleading; rename or retire after consumer migration.


## Wave5 follow-up candidates

- `src/ServiceInterface/InterfaceActionCatalogInterface.php` — deprecated compatibility interface; retire after consumers use `Catalog/InterfaceActionEndpointCatalogInterface`.
- `src/ServiceInterface/InterfaceActionEndpointInterface.php` — root endpoint contract; decide whether to move under `Catalog/` after endpoint consumers are classified.
- `src/Service/InterfaceActionCatalogService.php` — legacy/root endpoint catalog; compare against `Service/Interfacing/Action/InterfaceActionCatalogService.php` after runtime and bridge consumers are separated.
- `src/CatalogInterface/AttributeRegistry/InterfaceActionCatalogInterface.php` — keep for screen-scoped registry/runtime use; do not merge into endpoint catalog.

## Wave6 — action endpoint compatibility alias

Retain for now, but treat as deprecated after the canonical endpoint split:

- `src/ServiceInterface/InterfaceActionEndpointInterface.php`

Canonical replacement:

- `src/EndpointInterface/Catalog/InterfaceActionEndpointInterface.php`

## Wave7 follow-up candidates

Retain for compatibility in wave7, then retire after all consumers and host services use canonical contracts:

- `src/ServiceInterface/Access/AccessResolverInterface.php` — deprecated alias for `Access/InterfaceScreenActionAccessResolverInterface.php`.
- `src/ServiceInterface/AccessResolverInterface.php` — deprecated alias for `Access/InterfaceRoleAccessResolverInterface.php`.
- `src/ServiceInterface/Security/AccessResolverInterface.php` — deprecated alias for `Security/InterfaceScreenAccessResolverInterface.php`.
- `src/ServiceInterface/Shell/AccessResolverInterface.php` — deprecated alias for `Shell/InterfaceCapabilityAccessResolverInterface.php`.


## Wave8 follow-up candidates

Retain for compatibility after wave8, then retire after host references and imports move to canonical implementation names:

- `src/Service/Access/SymfonyAccessResolver.php` — wrapper for `Access/InterfaceSymfonyScreenActionAccessResolverService.php`.
- `src/Service/SymfonyAccessResolver.php` — wrapper for `Access/InterfaceSymfonyRoleAccessResolverService.php`.
- `src/Service/Security/SymfonyAccessResolver.php` — wrapper for `Security/InterfaceSymfonyScreenAccessResolverService.php`.
- `src/Service/Shell/SymfonyAccessResolver.php` — wrapper for `Shell/InterfaceSymfonyCapabilityAccessResolverService.php`.
- `src/Service/Security/AllowAllAccessResolver.php` — wrapper for `Security/InterfaceAllowAllScreenAccessResolverService.php`.
- `src/Service/Shell/AllowAllAccessResolver.php` — wrapper for `Shell/InterfaceAllowAllCapabilityAccessResolverService.php`.

## Wave 9 route/controller retirement candidates

- `config/routes.yaml` active controller imports — not used by the standalone `InterfaceKernel`; keep only as host compatibility note.
- Explicit `config/routes/interfacing.yaml` route declarations for billing/order/screen — retired in favor of attribute imports.
- Duplicate `/interfacing` ownership in `config/routes/interfacing_layout.yaml` — retired; layout routes are now scoped under `/interfacing/layout`.

## Wave10 controller decomposition note

No files are deleted in wave10. The old direct ecommerce-provider injections inside `InterfaceController` are retired by code change, not by file removal.

Next candidates:

- Move dynamic `/interfacing/{id}` screen payload assembly to `InterfaceScreenViewBuilderInterface` once HTTP exception mapping is aligned.
- Split `InterfacingWorkspaceViewBuilder` into narrower page-family builders if it grows beyond dashboard/workbench aggregation responsibility.

## Wave 11 follow-up candidates

- Review `InterfaceController` after dynamic route extraction; it should now remain a static workspace/page controller only.
- Review legacy route `/interfacing/screen/{id}` for eventual retirement once external consumers use `/interfacing/{id}` or the catalog route.

## Wave 12 controller decomposition note

No files are deleted in wave12. The old direct CRUD provider/router orchestration inside `InterfaceCrudExplorerController` is retired by code change, not by file removal.

Next candidates:

- Split `InterfaceCrudExplorerViewBuilderService` into narrower `CrudLinkPayloadBuilder`, `CrudRouteExpectationBuilder`, and `CrudOperationLaunchpadBuilder` only if it grows beyond CRUD Explorer responsibility.
- Review `InterfaceGenericCrudWorkbenchController` for similar route grammar/payload extraction after CRUD Explorer stabilizes.


## Wave13 follow-up candidates

- Replace demo-backed sample row construction in `InterfaceGenericCrudWorkbenchViewBuilderService` with resource-specific provider contributions once owning CRUD components publish concrete preview providers.
- Keep `InterfaceGenericCrudWorkbenchController` thin; do not reintroduce route-context or workbench payload assembly into the controller.

## Wave14 follow-up candidates

No files are deleted in wave14. The old inline sample-page construction inside `InterfaceGenericCrudWorkbenchViewBuilderService` is retired by code change, not file removal.

Next candidates:

- Add component-owned `InterfaceCrudWorkbenchPreviewProviderInterface` implementations for high-value resources once their repositories expose preview/query contracts.
- Consider splitting `InterfaceOrderSummaryPage`-based preview into a generic table preview DTO if non-order resources need a neutral payload model.


## Wave 15 follow-up candidates

- Audit external component preview providers to ensure they return `InterfaceCrudPreviewPage` rather than order-specific read models.
- Keep `InterfaceOrderSummaryPage` only for order-specific screens; do not use it as the generic CRUD bridge preview contract.


## Boundary wave16 retirement candidates

- `App\Interfacing\ContributionInterface\Crud\InterfaceCrudResourceContributionInterface` remains a deprecated compatibility alias; new contribution code should implement `InterfaceCrudResourceDescriptorContributionInterface`.
- Direct construction of `Contract\View\InterfaceCrudResourceLinkSet` inside contribution classes should be avoided. Contributions should publish `Contract\Crud\InterfaceCrudResourceDescriptorInterface` instead.

## Wave 17 follow-up candidates

- Hardcoded CRUD operation arrays inside `Contract/View/InterfaceCrudResourceLinkSet` are retained for compatibility. A later wave can move those view operation arrays behind `InterfaceCrudOperationGrammarProviderInterface` if the link-set view model should become fully grammar-provider driven.
- Avoid adding new `app_crud_*` route-name arrays in controllers or view builders; route grammar belongs to `InterfaceCrudOperationGrammarProviderInterface`.
## Wave 17.1 runtime hotfix note

- No new delete candidates.
- Fixed `InterfaceCrudWorkbenchPreviewProviderChainService` return type drift from order-specific `InterfaceOrderSummaryPage` to neutral `InterfaceCrudPreviewPage`.

## Wave18 Pinterfacing-4 hygiene

Explicit retired PHP marker files after Markdown replacement:

- `src/Service/README.php` → replaced by `src/Service/README.md`
- `src/ServiceInterface/README.php` → replaced by `src/ServiceInterface/README.md`

## Wave19 note

No retirement/delete candidates were introduced. Commerce finance coverage was added through canonical Symfony service/contribution classes and shell navigation edits.

## Src Wave 3 - route/layer ownership cleanup

- `src/Support/Doctor/InterfaceDoctorIssueInterface.php`
- `src/Support/Doctor/InterfaceDoctorReportInterface.php`
- `src/Presentation/LiveComponent/Screen/InterfaceScreenEmptyComponentInterface.php`
- `src/Presentation/LiveComponent/Screen/InterfaceScreenFormDemoComponentInterface.php`
- `src/Presentation/LiveComponent/Screen/InterfaceScreenGridDemoComponentInterface.php`
- `src/Presentation/LiveComponent/Screen/InterfaceScreenHealthComponentInterface.php`
- `src/Presentation/LiveComponent/Screen/InterfaceScreenHomeComponentInterface.php`
- `src/Presentation/LiveComponent/Screen/InterfaceScreenMetricDemoComponentInterface.php`
- `src/Presentation/LiveComponent/Screen/InterfaceScreenWizardDemoComponentInterface.php`
- `src/Presentation/LiveComponent/Widget/DataGrid/InterfaceDataGridWidgetComponentInterface.php`
- `src/Presentation/LiveComponent/Widget/DataGrid/InterfaceDataGridWidgetInterface.php`
- `src/Presentation/LiveComponent/Widget/Form/InterfaceFormWidgetComponentInterface.php`
- `src/Presentation/LiveComponent/Widget/Metric/InterfaceMetricWidgetComponentInterface.php`
- `src/Presentation/LiveComponent/Widget/Wizard/InterfaceWizardWidgetComponentInterface.php`
- `src/Integration/Twig/InterfaceClassNameTwigExtensionInterface.php`
- `src/Integration/Twig/InterfaceTwigExtensionInterface.php`
- `src/Application/Security/InterfacePermissionVoter.php`


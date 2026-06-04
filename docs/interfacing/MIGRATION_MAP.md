# Migration Map

## Source donor families
- `src/Domain/Interfacing/*`
- `src/DomainInterface/Interfacing/*`
- `src/Http/Interfacing/*`
- `src/HttpInterface/Interfacing/*`
- `src/Infra/Interfacing/*`
- `src/InfraInterface/Interfacing/*`
- `src/Service/*`
- `src/ServiceInterface/*`

## Evacuation guidance
- controllers and HTTP entry points -> `src/Presentation/Controller`.
- live components, screen builders, shell/layout/view-facing runtime -> `src/Presentation/*`.
- DTO, typed input/output, view-model contracts, UI contracts, zone contracts -> `src/Contract/*`.
- orchestration, commands, queries, runtime coordinators, security-aware use-cases -> `src/Application/*`.
- persistence adapters and repositories -> `src/Persistence/*`.
- reusable concrete services -> mirrored `src/Service/*`.
- reusable service contracts -> mirrored `src/ServiceInterface/*`.
- Symfony/Twig/browser/vendor/provider glue -> `src/Integration/*`.
- fixtures, doctor, smoke, QA, reports, demo helpers -> `src/Support/*`.

## Temporary rule
Do not mass-move blindly. Evacuate file-by-file when a touched area is already being changed.


## Wave 3 actual evacuation
- `src/Http/Interfacing/Controller/*` -> `src/Presentation/Controller/*`
- `src/Http/Interfacing/Live/*` -> `src/Presentation/LiveComponent/*`
- `src/Http/Interfacing/Health/Controller/InterfacingHealthController.php` -> `src/Presentation/Controller/InterfacingHealthController.php`
- `src/Http/Interfacing/Layout/Controller/InterfaceLayoutController.php` -> `src/Presentation/Controller/InterfaceLayoutController.php`
- `src/Domain/Interfacing/Layout/InterfaceLayoutSlot.php` -> `src/Contract/ValueObject/InterfaceLayoutSlot.php`
- `src/Domain/Interfacing/Error/*` -> `src/Contract/Error/*`

This wave intentionally keeps `HttpInterface`, `Domain`, and `Infra` as donor trees where broader code still depends on them, but starts active runtime evacuation into canonical target branches.

## Wave 4
- `src/Infra/Interfacing/Http/*` => `src/Presentation/Controller/*`
- `src/Infra/Interfacing/Live/*` => `src/Presentation/LiveComponent/*`
- `src/InfraInterface/Interfacing/Live/*` => `src/Presentation/LiveComponent/*`
- `src/Infra/Interfacing/Twig/*` => `src/Integration/Twig/*`
- `src/InfraInterface/Interfacing/Twig/*` => `src/Integration/Twig/*`
- `src/Infra/Interfacing/Symfony/*` => `src/Integration/Symfony/*`
- `src/Infra/Interfacing/Security/InterfacePermissionVoter.php` => `src/Application/Security/InterfacePermissionVoter.php`

## Wave 5
- `src/Infra/Interfacing/Adapter/CategoryApi/*` -> `src/Integration/CategoryApi/*`
- `src/Infra/Interfacing/Config/*` -> `src/Support/Configuration/*`
- `src/Infra/Interfacing/Command/*` and `src/Infra/Interfacing/Console/*` -> `src/Support/Console/*`
- `src/Infra/Interfacing/Context/InterfaceDemoBaseContextProviderService.php` -> `src/Provider/Runtime/Context/InterfaceDemoBaseContextProvider.php`
- `src/Infra/Interfacing/Demo/InterfaceDemoUserProfileStoreService.php` -> `src/Support/Demo/InterfaceDemoUserProfileStoreService.php`
- `src/InfraInterface/Interfacing/Demo/InterfaceDemoUserProfileStoreInterface.php` -> `src/ServiceInterface/Support/Demo/InterfaceDemoUserProfileStoreInterface.php`
- `src/Infra/Interfacing/Telemetry/InterfaceTelemetryService.php` -> `src/Support/Telemetry/InterfaceTelemetryService.php`
- `src/InfraInterface/Interfacing/Telemetry/InterfaceTelemetryInterface.php` -> `src/ServiceInterface/Support/Telemetry/InterfaceTelemetryInterface.php`
- Duplicate demo providers in `src/Infra/Interfacing/Provider/*` removed in favor of active `src/Service/*` implementations.


## Wave 6
- `src/Http/Interfacing/Command/DoctorCommand.php` -> `src/Support/Console/InterfaceDoctorJsonCommand.php`
- `src/Http/Interfacing/Command/InterfaceCatalogCommand.php` -> `src/Support/Console/InterfaceCatalogCommand.php`
- `src/Http/Interfacing/Command/InterfaceDoctorCommand.php` -> `src/Support/Console/InterfaceDoctorSummaryCommand.php`
- `src/Http/Interfacing/Console/InterfaceDoctorCommand.php` -> `src/Support/Console/InterfaceDoctorCommand.php`
- `src/Http/Interfacing/Component/InterfaceDoctorComponent.php` -> `src/Presentation/LiveComponent/InterfaceDoctorComponent.php`
- donor trees removed: `src/Http`, `src/HttpInterface`, `src/Infra`, `src/InfraInterface`


## Wave 7
- `src/Domain/Interfacing/Value/InterfaceActionId.php` -> `src/Contract/ValueObject/InterfaceActionId.php`
- `src/Domain/Interfacing/Value/InterfaceScreenId.php` -> `src/Contract/ValueObject/InterfaceScreenId.php`
- `src/Domain/Interfacing/Runtime/InterfacePermission.php` -> `src/Application/Security/InterfacePermission.php`
- `src/Domain/Interfacing/Runtime/InterfaceTenantId.php` -> `src/Contract/ValueObject/InterfaceTenantId.php`
- `src/Domain*/Interfacing/Ui/*` -> `src/Contract/Ui/*`
- `src/Domain/Interfacing/Error/InterfaceDomainOperationFailed.php` -> `src/Contract/Error/InterfaceDomainOperationFailed.php`
- `src/Domain*/Interfacing/Doctor/*` -> `src/Support/Doctor/*`
- dead duplicate runtime ids removed: `src/Domain/Interfacing/Runtime/InterfaceActionId.php`, `src/Domain/Interfacing/Runtime/InterfaceScreenId.php`

## Wave 8
- `Domain/Interfacing/Model/Layout/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/Layout/*` -> `Contract/View/*`
- `Domain/Interfacing/Model/Screen/InterfaceScreenSpec.php` -> `Contract/View/InterfaceScreenSpec.php`
- `DomainInterface/Interfacing/Model/Screen/InterfaceScreenSpecInterface.php` -> `Contract/View/InterfaceScreenSpecInterface.php`
- `Domain/Interfacing/Model/InterfaceScreenId.php` -> absorbed by `Contract/ValueObject/InterfaceScreenId.php`
- `DomainInterface/Interfacing/Model/InterfaceScreenIdInterface.php` -> `Contract/ValueObject/InterfaceScreenIdInterface.php`

## Wave 9
- `Domain/Interfacing/Access/*` -> `Contract/Access/*`
- `Domain/Interfacing/Action/{InterfaceActionRequest,InterfaceActionResult,InterfaceActionRuntime}` -> `Contract/Action/*`
- `Domain/Interfacing/Audit/*` -> `Support/Audit/*`
- `DomainInterface/Interfacing/Access/AccessResolverInterface` -> `ServiceInterface/Interfacing/Access/AccessResolverInterface`
- `DomainInterface/Interfacing/Audit/InterfaceAuditSinkInterface` -> `ServiceInterface/Support/Audit/InterfaceAuditSinkInterface`
- `DomainInterface/Interfacing/Action/{InterfaceActionIdInterface,InterfaceActionResultInterface,InterfaceActionRuntimeInterface}` -> contract/value-contract layer

## Wave 10
- `Domain/Interfacing/Model/Form/*` -> `Contract/View/*` and `Contract/Dto/InterfaceFormSubmitResult*`
- `DomainInterface/Interfacing/Model/Form/*` -> `Contract/View/*` and `Contract/Dto/*`
- `Domain/Interfacing/Model/Metric/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/Metric/*` -> `Contract/View/*`
- `Domain/Interfacing/Model/Wizard/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/Wizard/*` -> `Contract/View/*`
- `Domain/Interfacing/Spec/{InterfaceFormFieldSpec,InterfaceFormSpec,InterfaceMetricSpec,InterfaceWizardStepSpec,InterfaceWizardSpec}` -> `Contract/Spec/*`


## Wave 11
- `Domain/Interfacing/Model/BulkAction/*` -> `Contract/View/InterfaceBulkActionSpec*` and `Contract/Dto/InterfaceBulkActionResult*`
- `DomainInterface/Interfacing/Model/BulkAction/*` -> `Contract/View/*` and `Contract/Dto/*`
- `Domain/Interfacing/Model/DataGrid/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/DataGrid/*` -> `Contract/View/*`
- `Domain/Interfacing/Model/Shell/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/Shell/*` -> `Contract/View/*`
- `Domain/Interfacing/Query/{BillingMeter*,OrderSummary*}` -> `Contract/Dto/*`
- unused donor query interfaces under `DomainInterface/Interfacing/Query/*` removed in favor of active `ServiceInterface/Interfacing/Query/*`

## Wave 12
- Domain/Interfacing/Attribute/* -> Integration/Symfony/Attribute/*
- Domain/Interfacing/Demo/InterfaceDemoUserProfileInput -> Contract/Dto/InterfaceDemoUserProfileInput
- Domain/Interfacing/Model/CategoryFormModel -> Contract/Dto/InterfaceCategoryFormInput
- Domain/Interfacing/Model/InterfaceCategoryItemView -> Contract/Dto/InterfaceCategoryItemView
- Domain/Interfacing/Model/InterfaceTelemetryEvent -> Support/Telemetry/InterfaceTelemetryEvent
- Domain/Interfacing/Model/InterfaceUiState -> Contract/Dto/InterfaceUiState
- Domain/Interfacing/Model/InterfaceWidgetId -> Contract/ValueObject/InterfaceWidgetId

## Wave 13
- Layout legacy spec/id/provider contracts moved from Domain/DomainInterface to Contract/View, Contract/ValueObject and ServiceInterface/Interfacing/Layout.
- Screen legacy spec/id/provider contracts moved from Domain/DomainInterface to Contract/View, Contract/ValueObject and ServiceInterface/Interfacing/Screen.
- InterfaceLayoutScreenSpec builder now returns Contract\View\InterfaceLayoutScreenSpec.

## Wave 14
- removed src/Domain and src/DomainInterface after final consumer cutover
- cut remaining action/context/security/telemetry consumer references to ServiceInterface/Contract layers
- switched old screen/nav/action paths to contract/runtime layers

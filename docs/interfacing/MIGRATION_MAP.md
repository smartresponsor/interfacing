# Migration Map

## Source donor families
- `src/Domain/Interfacing/*`
- `src/DomainInterface/Interfacing/*`
- `src/Http/Interfacing/*`
- `src/HttpInterface/Interfacing/*`
- `src/Infra/Interfacing/*`
- `src/InfraInterface/Interfacing/*`
- `src/Service/Interfacing/*`
- `src/ServiceInterface/Interfacing/*`

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
- `src/Http/Interfacing/Controller/*` -> `src/Presentation/Controller/Interfacing/*`
- `src/Http/Interfacing/Live/*` -> `src/Presentation/LiveComponent/Interfacing/*`
- `src/Http/Interfacing/Health/Controller/InterfacingHealthController.php` -> `src/Presentation/Controller/Interfacing/InterfacingHealthController.php`
- `src/Http/Interfacing/Layout/Controller/LayoutController.php` -> `src/Presentation/Controller/Interfacing/LayoutController.php`
- `src/Domain/Interfacing/Layout/LayoutSlot.php` -> `src/Contract/ValueObject/LayoutSlot.php`
- `src/Domain/Interfacing/Error/*` -> `src/Contract/Error/*`

This wave intentionally keeps `HttpInterface`, `Domain`, and `Infra` as donor trees where broader code still depends on them, but starts active runtime evacuation into canonical target branches.

## Wave 4
- `src/Infra/Interfacing/Http/*` => `src/Presentation/Controller/Interfacing/*`
- `src/Infra/Interfacing/Live/*` => `src/Presentation/LiveComponent/Interfacing/*`
- `src/InfraInterface/Interfacing/Live/*` => `src/Presentation/LiveComponent/Interfacing/*`
- `src/Infra/Interfacing/Twig/*` => `src/Integration/Twig/*`
- `src/InfraInterface/Interfacing/Twig/*` => `src/Integration/Twig/*`
- `src/Infra/Interfacing/Symfony/*` => `src/Integration/Symfony/*`
- `src/Infra/Interfacing/Security/InterfacingPermissionVoter.php` => `src/Application/Security/InterfacingPermissionVoter.php`

## Wave 5
- `src/Infra/Interfacing/Adapter/CategoryApi/*` -> `src/Integration/CategoryApi/*`
- `src/Infra/Interfacing/Config/*` -> `src/Support/Configuration/*`
- `src/Infra/Interfacing/Command/*` and `src/Infra/Interfacing/Console/*` -> `src/Support/Console/*`
- `src/Infra/Interfacing/Context/DemoBaseContextProvider.php` -> `src/Service/Interfacing/Runtime/Context/DemoBaseContextProvider.php`
- `src/Infra/Interfacing/Demo/DemoUserProfileStore.php` -> `src/Support/Demo/DemoUserProfileStore.php`
- `src/InfraInterface/Interfacing/Demo/DemoUserProfileStoreInterface.php` -> `src/ServiceInterface/Support/Demo/DemoUserProfileStoreInterface.php`
- `src/Infra/Interfacing/Telemetry/InterfacingTelemetry.php` -> `src/Support/Telemetry/InterfacingTelemetry.php`
- `src/InfraInterface/Interfacing/Telemetry/InterfacingTelemetryInterface.php` -> `src/ServiceInterface/Support/Telemetry/InterfacingTelemetryInterface.php`
- Duplicate demo providers in `src/Infra/Interfacing/Provider/*` removed in favor of active `src/Service/Interfacing/*` implementations.


## Wave 6
- `src/Http/Interfacing/Command/DoctorCommand.php` -> `src/Support/Console/InterfacingDoctorJsonCommand.php`
- `src/Http/Interfacing/Command/InterfacingCatalogCommand.php` -> `src/Support/Console/InterfacingCatalogCommand.php`
- `src/Http/Interfacing/Command/InterfacingDoctorCommand.php` -> `src/Support/Console/InterfacingDoctorSummaryCommand.php`
- `src/Http/Interfacing/Console/InterfacingDoctorCommand.php` -> `src/Support/Console/InterfacingDoctorCommand.php`
- `src/Http/Interfacing/Component/InterfacingDoctorComponent.php` -> `src/Presentation/LiveComponent/Interfacing/InterfacingDoctorComponent.php`
- donor trees removed: `src/Http`, `src/HttpInterface`, `src/Infra`, `src/InfraInterface`


## Wave 7
- `src/Domain/Interfacing/Value/ActionId.php` -> `src/Contract/ValueObject/ActionId.php`
- `src/Domain/Interfacing/Value/ScreenId.php` -> `src/Contract/ValueObject/ScreenId.php`
- `src/Domain/Interfacing/Runtime/InterfacingPermission.php` -> `src/Application/Security/InterfacingPermission.php`
- `src/Domain/Interfacing/Runtime/TenantId.php` -> `src/Contract/ValueObject/TenantId.php`
- `src/Domain*/Interfacing/Ui/*` -> `src/Contract/Ui/*`
- `src/Domain/Interfacing/Error/DomainOperationFailed.php` -> `src/Contract/Error/DomainOperationFailed.php`
- `src/Domain*/Interfacing/Doctor/*` -> `src/Support/Doctor/*`
- dead duplicate runtime ids removed: `src/Domain/Interfacing/Runtime/ActionId.php`, `src/Domain/Interfacing/Runtime/ScreenId.php`

## Wave 8
- `Domain/Interfacing/Model/Layout/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/Layout/*` -> `Contract/View/*`
- `Domain/Interfacing/Model/Screen/ScreenSpec.php` -> `Contract/View/ScreenSpec.php`
- `DomainInterface/Interfacing/Model/Screen/ScreenSpecInterface.php` -> `Contract/View/ScreenSpecInterface.php`
- `Domain/Interfacing/Model/ScreenId.php` -> absorbed by `Contract/ValueObject/ScreenId.php`
- `DomainInterface/Interfacing/Model/ScreenIdInterface.php` -> `Contract/ValueObject/ScreenIdInterface.php`

## Wave 9
- `Domain/Interfacing/Access/*` -> `Contract/Access/*`
- `Domain/Interfacing/Action/{ActionRequest,ActionResult,ActionRuntime}` -> `Contract/Action/*`
- `Domain/Interfacing/Audit/*` -> `Support/Audit/*`
- `DomainInterface/Interfacing/Access/AccessResolverInterface` -> `ServiceInterface/Interfacing/Access/AccessResolverInterface`
- `DomainInterface/Interfacing/Audit/AuditSinkInterface` -> `ServiceInterface/Support/Audit/AuditSinkInterface`
- `DomainInterface/Interfacing/Action/{ActionIdInterface,ActionResultInterface,ActionRuntimeInterface}` -> contract/value-contract layer

## Wave 10
- `Domain/Interfacing/Model/Form/*` -> `Contract/View/*` and `Contract/Dto/FormSubmitResult*`
- `DomainInterface/Interfacing/Model/Form/*` -> `Contract/View/*` and `Contract/Dto/*`
- `Domain/Interfacing/Model/Metric/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/Metric/*` -> `Contract/View/*`
- `Domain/Interfacing/Model/Wizard/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/Wizard/*` -> `Contract/View/*`
- `Domain/Interfacing/Spec/{FormFieldSpec,FormSpec,MetricSpec,WizardStepSpec,WizardSpec}` -> `Contract/Spec/*`


## Wave 11
- `Domain/Interfacing/Model/BulkAction/*` -> `Contract/View/BulkActionSpec*` and `Contract/Dto/BulkActionResult*`
- `DomainInterface/Interfacing/Model/BulkAction/*` -> `Contract/View/*` and `Contract/Dto/*`
- `Domain/Interfacing/Model/DataGrid/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/DataGrid/*` -> `Contract/View/*`
- `Domain/Interfacing/Model/Shell/*` -> `Contract/View/*`
- `DomainInterface/Interfacing/Model/Shell/*` -> `Contract/View/*`
- `Domain/Interfacing/Query/{BillingMeter*,OrderSummary*}` -> `Contract/Dto/*`
- unused donor query interfaces under `DomainInterface/Interfacing/Query/*` removed in favor of active `ServiceInterface/Interfacing/Query/*`

## Wave 12
- Domain/Interfacing/Attribute/* -> Integration/Symfony/Attribute/*
- Domain/Interfacing/Demo/DemoUserProfileInput -> Contract/Dto/DemoUserProfileInput
- Domain/Interfacing/Model/CategoryFormModel -> Contract/Dto/CategoryFormInput
- Domain/Interfacing/Model/CategoryItemView -> Contract/Dto/CategoryItemView
- Domain/Interfacing/Model/TelemetryEvent -> Support/Telemetry/TelemetryEvent
- Domain/Interfacing/Model/UiState -> Contract/Dto/UiState
- Domain/Interfacing/Model/WidgetId -> Contract/ValueObject/WidgetId

## Wave 13
- Layout legacy spec/id/provider contracts moved from Domain/DomainInterface to Contract/View, Contract/ValueObject and ServiceInterface/Interfacing/Layout.
- Screen legacy spec/id/provider contracts moved from Domain/DomainInterface to Contract/View, Contract/ValueObject and ServiceInterface/Interfacing/Screen.
- LayoutScreenSpec builder now returns Contract\View\LayoutScreenSpec.

## Wave 14
- removed src/Domain and src/DomainInterface after final consumer cutover
- cut remaining action/context/security/telemetry consumer references to ServiceInterface/Contract layers
- switched old screen/nav/action paths to contract/runtime layers

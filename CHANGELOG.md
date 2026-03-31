## [Unreleased]
- wave 3: evacuated presentation entrypoints from `src/Http/...` into `src/Presentation/...`
- wave 3: evacuated layout/error contracts from `src/Domain/...` into `src/Contract/...`

# Changelog

## Unreleased
- wave 2: adapted root manifests and Codex prompt to owner motifs and stricter Symfony-oriented canon.
- wave 2: replaced target-tree guidance to avoid new Domain/Infra growth and to preserve mirrored Service/ServiceInterface trees.

## 2026-03-28 — wave 4
- evacuated infrastructure-facing HTTP controllers into `src/Presentation/Controller/Interfacing`
- evacuated Live Components and their interfaces into `src/Presentation/LiveComponent/Interfacing`
- moved Twig extensions and contracts into `src/Integration/Twig`
- moved Symfony bundle/compiler passes into `src/Integration/Symfony`
- moved `InterfacingPermissionVoter` into `src/Application/Security`
- updated service config and tests to target the new namespaces


## Wave 5
- Evacuated remaining active `Infra` runtime pieces into `Integration`, `Support`, `Service`, and `ServiceInterface`.
- Renamed the permission sample console command class to `InterfacingPermissionSampleCommand` to match its actual responsibility.
- Removed duplicate unused demo providers from `src/Infra/Interfacing/Provider`.

## Wave 6
- moved remaining HTTP-layer donor commands into `src/Support/Console`
- moved remaining doctor live component into `src/Presentation/LiveComponent/Interfacing`
- removed empty donor trees: `src/Http`, `src/HttpInterface`, `src/Infra`, `src/InfraInterface`


## Wave 7
- evacuated active value objects from `src/Domain/Interfacing/Value` into `src/Contract/ValueObject`
- moved active UI contracts and bags from `src/Domain*/Interfacing/Ui` into `src/Contract/Ui`
- moved `InterfacingPermission` into `src/Application/Security`
- moved doctor report/issue contracts from `src/Domain*/Interfacing/Doctor` into `src/Support/Doctor`
- moved `DomainOperationFailed` into `src/Contract/Error`
- removed dead duplicate runtime ids from `src/Domain/Interfacing/Runtime`

## 2026-03-28 wave 8
- Moved active layout/view model contracts from Domain/DomainInterface into Contract/View.
- Added canonical Contract/ValueObject interfaces for ScreenId and LayoutId, and strengthened ScreenId compatibility helpers.
- Updated runtime, registry, security, and provider layers to use Contract/View and Contract/ValueObject types.
- Removed moved donor files from Domain/DomainInterface model layout/screen branches.

## Wave 9
- Evacuated active access contracts from Domain into Contract/Access.
- Evacuated active action request/result/runtime contracts into Contract/Action.
- Moved audit event contracts into Support/Audit and audit sink contract into ServiceInterface/Support/Audit.
- Moved access resolver contract into ServiceInterface/Interfacing/Access.
- Introduced Contract/ValueObject/ActionIdInterface and strengthened ActionId.
- Updated live references in services, controllers, tests, and support doctor reporting.

## Wave 10
- moved active form, metric, and wizard widget contracts out of `Domain/DomainInterface` into `Contract/View` and `Contract/Dto`
- introduced `Contract/Spec` for builder-oriented readonly form/metric/wizard specs
- updated builders, widget handlers, live components, and service interfaces to consume the new contract namespaces
- removed moved donor files from `src/Domain/Interfacing/Model/{Form,Metric,Wizard}`, `src/DomainInterface/Interfacing/Model/{Form,Metric,Wizard}`, and `src/Domain/Interfacing/Spec/*`

## Wave 11
- moved active shell, bulk-action, and data-grid contracts from `Domain/DomainInterface` into `Contract/View` and `Contract/Dto`
- moved billing/order query page-row DTOs out of `Domain/Interfacing/Query` into `Contract/Dto`
- updated live components, shell services, query services, and widget registries/providers to consume the new contract namespaces
- removed moved donor files from `src/Domain*/Interfacing/Model/{BulkAction,DataGrid,Shell}` and `src/Domain*/Interfacing/Query/*`

## Wave 12
- Moved Symfony attributes into Integration/Symfony/Attribute.
- Moved demo/category DTO carriers into Contract/Dto.
- Moved telemetry event into Support/Telemetry.
- Moved WidgetId and UiState out of Domain leftovers into Contract layer.
- Removed dead duplicate ActionId from Domain.

- Wave 13: moved layout/screen legacy interfaces and specs out of Domain/DomainInterface into Contract/View, Contract/ValueObject, and ServiceInterface/Interfacing/*; updated doctor/layout/screen services accordingly.

## Wave 14
- removed src/Domain and src/DomainInterface after final consumer cutover
- cut remaining action/context/security/telemetry consumer references to ServiceInterface/Contract layers
- switched old screen/nav/action paths to contract/runtime layers

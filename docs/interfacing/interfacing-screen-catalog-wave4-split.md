# Interfacing wave4: Screen catalog / registry split

## Decision

Interfacing now distinguishes three screen lookup concepts instead of treating every
screen-related service as a generic `InterfaceScreenCatalogService` or `InterfaceScreenRegistryService`.

## Canonical contracts

| Concern | Canonical contract | Purpose |
|---|---|---|
| UI screen specification catalog | `App\Interfacing\CatalogInterface\InterfaceScreenSpecCatalogInterface` | Returns `InterfaceScreenSpecInterface` objects for controllers, doctor reports, and UI view payloads. |
| Registry descriptor catalog | `App\Interfacing\CatalogInterface\AttributeRegistry\InterfaceScreenCatalogInterface` | Holds `InterfaceScreenDescriptorInterface` records populated by registry/compiler-pass style integrations. |
| Runtime screen mapping | `App\Interfacing\RegistryInterface\Runtime\InterfaceScreenRegistryInterface` and `Runtime\InterfaceScreenCatalogInterface` | Resolves runtime `InterfaceScreenId` to component names and lists runtime screen ids. |

## Transitional compatibility

`App\Interfacing\ServiceInterface\InterfaceScreenCatalogInterface` remains as a deprecated
compatibility interface that extends `Catalog\InterfaceScreenSpecCatalogInterface`.

Existing services that require the old interface continue to resolve through the same concrete
`App\Interfacing\Service\InterfaceScreenCatalogService` service. New code should use the explicit
`Catalog\InterfaceScreenSpecCatalogInterface` contract.

## Do not collapse

Do not merge runtime screen mapping, descriptor registry, and UI screen specs into a single
interface. They answer different questions and have different payload shapes.

## Next closure candidates

- Move remaining new consumers away from deprecated root `InterfaceScreenCatalogInterface`.
- Decide whether `Screen\InterfaceScreenCatalogInterface` should remain as a value-object-id catalog or be retired.
- Decide whether `Registry\InterfaceScreenRegistryInterface` should be renamed to `ScreenSpecRegistryInterface` if it remains spec-based.

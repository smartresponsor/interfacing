# Interfacing wave4: Screen catalog / registry split

## Decision

Interfacing now distinguishes three screen lookup concepts instead of treating every
screen-related service as a generic `ScreenCatalog` or `ScreenRegistry`.

## Canonical contracts

| Concern | Canonical contract | Purpose |
|---|---|---|
| UI screen specification catalog | `App\Interfacing\ServiceInterface\Interfacing\Catalog\ScreenSpecCatalogInterface` | Returns `ScreenSpecInterface` objects for controllers, doctor reports, and UI view payloads. |
| Registry descriptor catalog | `App\Interfacing\ServiceInterface\Interfacing\Registry\ScreenCatalogInterface` | Holds `ScreenDescriptorInterface` records populated by registry/compiler-pass style integrations. |
| Runtime screen mapping | `App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface` and `Runtime\ScreenCatalogInterface` | Resolves runtime `ScreenId` to component names and lists runtime screen ids. |

## Transitional compatibility

`App\Interfacing\ServiceInterface\Interfacing\ScreenCatalogInterface` remains as a deprecated
compatibility interface that extends `Catalog\ScreenSpecCatalogInterface`.

Existing services that require the old interface continue to resolve through the same concrete
`App\Interfacing\Service\Interfacing\ScreenCatalog` service. New code should use the explicit
`Catalog\ScreenSpecCatalogInterface` contract.

## Do not collapse

Do not merge runtime screen mapping, descriptor registry, and UI screen specs into a single
interface. They answer different questions and have different payload shapes.

## Next closure candidates

- Move remaining new consumers away from deprecated root `ScreenCatalogInterface`.
- Decide whether `Screen\ScreenCatalogInterface` should remain as a value-object-id catalog or be retired.
- Decide whether `Registry\ScreenRegistryInterface` should be renamed to `ScreenSpecRegistryInterface` if it remains spec-based.

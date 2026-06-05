# Interfacing service-interface dedup wave3

## Purpose

This wave reduces contract ambiguity without deleting runtime code. The active Symfony component must expose one canonical contract path for each responsibility and keep transitional aliases only where existing code or host applications may still import an older namespace.

## Canonical contract directions

| Responsibility | Canonical contract path | Notes |
| --- | --- | --- |
| Screen contribution providers | `src/ProviderInterface/InterfaceScreenProviderInterface.php` | Produces `InterfaceScreenSpecInterface` objects for catalogs and registries. |
| Runtime screen component maps | `src/ProviderInterface/Runtime/InterfaceScreenProviderInterface.php` | Different contract: `id()` and `map()`. Must not be merged with contribution providers. |
| Request/base context | `src/ProviderInterface/Context/InterfaceBaseContextProviderInterface.php` | The root-level interface is now only a deprecated compatibility alias. |
| Action contribution providers | `src/ProviderInterface/InterfaceActionProviderInterface.php` | Tagged with `interfacing.action_provider`. |
| Screen catalogs | Keep separate until a later API decision | Existing string-id, value-object-id, registry-descriptor, and runtime-id-list catalogs are not method-compatible. |
| Authorization resolvers | Keep separate until a later API decision | Shell capability, declarative screen, and request-aware screen/action resolvers serve different call sites. |

## Changes in this wave

- Root `InterfaceScreenProviderInterface` now extends the canonical provider interface and carries an explicit deprecated marker.
- `Screen\InterfaceScreenProviderInterface` now extends the canonical provider interface and carries an explicit deprecated marker.
- `InterfaceBaseContextProviderInterface` now extends `Context\InterfaceBaseContextProviderInterface` and carries an explicit deprecated marker.
- `Demo\InterfaceDemoScreenProviderService`, `Screen\InterfaceScreenCatalogService`, and `Screen\InterfaceScreenRegistryService` now import the canonical provider interface.
- No non-compatible catalog/authorization interfaces were collapsed in this wave.

## Follow-up candidates

1. Migrate any remaining imports from root `InterfaceScreenProviderInterface` and `Screen\InterfaceScreenProviderInterface` to `Provider\InterfaceScreenProviderInterface`.
2. Decide whether string-id screen catalogs or value-object-id screen catalogs are canonical.
3. Decide whether shell, screen, and request-aware screen/action authorization resolvers should stay as distinct contracts or be normalized behind a facade.
4. After host compatibility is confirmed, delete deprecated alias interfaces through an explicit touched-file retirement wave.

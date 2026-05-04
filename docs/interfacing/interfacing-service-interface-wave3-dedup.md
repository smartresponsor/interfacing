# Interfacing service-interface dedup wave3

## Purpose

This wave reduces contract ambiguity without deleting runtime code. The active Symfony component must expose one canonical contract path for each responsibility and keep transitional aliases only where existing code or host applications may still import an older namespace.

## Canonical contract directions

| Responsibility | Canonical contract path | Notes |
| --- | --- | --- |
| Screen contribution providers | `src/ServiceInterface/Interfacing/Provider/ScreenProviderInterface.php` | Produces `ScreenSpecInterface` objects for catalogs and registries. |
| Runtime screen component maps | `src/ServiceInterface/Interfacing/Runtime/ScreenProviderInterface.php` | Different contract: `id()` and `map()`. Must not be merged with contribution providers. |
| Request/base context | `src/ServiceInterface/Interfacing/Context/BaseContextProviderInterface.php` | The root-level interface is now only a deprecated compatibility alias. |
| Action contribution providers | `src/ServiceInterface/Interfacing/Provider/ActionProviderInterface.php` | Tagged with `interfacing.action_provider`. |
| Screen catalogs | Keep separate until a later API decision | Existing string-id, value-object-id, registry-descriptor, and runtime-id-list catalogs are not method-compatible. |
| Access resolvers | Keep separate until a later API decision | Shell, security, and request-aware access resolvers serve different call sites. |

## Changes in this wave

- Root `ScreenProviderInterface` now extends the canonical provider interface and carries an explicit deprecated marker.
- `Screen\ScreenProviderInterface` now extends the canonical provider interface and carries an explicit deprecated marker.
- `BaseContextProviderInterface` now extends `Context\BaseContextProviderInterface` and carries an explicit deprecated marker.
- `Demo\DemoScreenProvider`, `Screen\ScreenCatalog`, and `Screen\ScreenRegistry` now import the canonical provider interface.
- No non-compatible catalog/access interfaces were collapsed in this wave.

## Follow-up candidates

1. Migrate any remaining imports from root `ScreenProviderInterface` and `Screen\ScreenProviderInterface` to `Provider\ScreenProviderInterface`.
2. Decide whether string-id screen catalogs or value-object-id screen catalogs are canonical.
3. Decide whether shell/security/access request-aware resolvers should stay as distinct contracts or be normalized behind a facade.
4. After host compatibility is confirmed, delete deprecated alias interfaces through an explicit touched-file retirement wave.

# Interfacing wave18 Pinterfacing-4 hygiene

Wave18 closes non-runtime Composer Pinterfacing-4 warnings after the boundary canon milestone 17.4.

## Changes

- Converted PHP marker README files to Markdown documentation files so Composer no longer treats them as Pinterfacing-4 classes.
- Corrected `ScreenViewBuilderPayloadContractTest` to the configured dev namespace `App\Interfacing\Tests\...`.
- Corrected test imports to the component-scoped `App\Interfacing\...` namespace and the canonical shell capability access contract.

## Boundary

This wave is intentionally hygienic only. It does not change public routes, service ids, runtime aliases, Twig payloads, or CRUD bridge behavior.

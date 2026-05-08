# Interfacing Admin Body RC Readiness Gate

This document marks the current admin body contract line as an RC readiness gate for `admin-body-rc1`.

The RC readiness gate is not a new rendering layer and not a new UI adapter. It is the final gate that confirms the already-built contract is coherent enough to promote from active construction into RC hardening.

## Gate entrypoints

- PHP gate: `tools/interfacing/admin-body-rc-readiness.php`
- PowerShell wrapper: `tools/interfacing/admin-body-rc-readiness.ps1`
- Consolidated guard dependency: `tools/interfacing/admin-body-rc-guard.php`

## Readiness criteria

The gate confirms the following discipline:

- single ecosystem shell owns the global top menu, panels, quick menu, and footer;
- central admin body mount owns CRUD/admin content inside the body slot;
- Ant Design ProComponents primary provider owns table/form/detail admin workbench rendering;
- PrimeReact secondary provider remains a rich-facade/special widget surface;
- versioned schema manifest is present and indexed;
- runtime smoke harness passes for provider-required-error and primary-provider-ready scenarios;
- residual audit is clean;
- No HostApp copy surface is the primary integration model;
- No Cruding-specific adapter is the primary integration model.

## Operator command

```bash
php tools/interfacing/admin-body-rc-readiness.php
```

On Windows PowerShell:

```powershell
powershell -ExecutionPolicy Bypass -File tools/interfacing/admin-body-rc-readiness.ps1
```

## RC interpretation

`admin-body-rc1` means the contract surface is ready for RC-style stabilization:

- no more adapter/copy direction for Cruding;
- no more native Twig expansion as the final admin design system;
- future work should focus on real provider implementation, runtime proof, consumer wiring, and bug fixes;
- architecture additions must be justified by a missing consumer contract rather than by visual experimentation.

## UI provider canon

The RC readiness gate includes `tools/interfacing/admin-body-ui-provider-canon-guard.php`. This ensures Ant Design ProComponents remains the primary admin/workbench provider, PrimeReact remains secondary/rich-facade, and Bootstrap or handmade Twig CSS is not inferred from composer dependencies.

Read: `docs/interfacing/interfacing-admin-body-ui-provider-canon.md`.


## Strict provider rendering

See `docs/interfacing/interfacing-admin-body-strict-provider-rendering.md`. Admin body UI is provider-required: Ant Design ProComponents renders the primary workbench, PrimeReact remains secondary rich-facade, and Twig publishes only shell/mount/schema/script wiring. Run `npm install`, `npm run ui:build`, and then `php tools/interfacing/admin-body-rc-readiness.php`.

- `tools/interfacing/admin-body-consumer-provider-adoption-audit.php` — audits visible consumer pages for strict provider adoption before component-specific migration waves.

## Consumer adoption status

RC readiness includes the visible-page adoption audit and runner. Interfacing is ready to audit consumers, while actual visual migration must be applied in each consumer current slice.



## Ecosystem/e-commerce UI coverage

Interfacing maintains an ecosystem-wide page coverage map at `docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md`. Consumer adoption work must compare real pages against this component/page family map instead of treating one repository archive as the whole UI surface. Run `php tools/interfacing/admin-body-ecosystem-ui-coverage-audit.php` before provider adoption waves.

- frontend build hardening: React/ReactDOM `^18.3.1`, Vite `publicDir: false`, and canonical provider bundle output are guarded.


Bridge provider surface: Bridge owns route/resource adoption; Interfacing renders provider-owned UI; direct consumer template rewrite is not the primary path. Guard: `tools/interfacing/admin-body-bridge-provider-surface-guard.php`.

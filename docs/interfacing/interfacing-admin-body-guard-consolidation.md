# Interfacing admin body guard consolidation

This document defines the RC-facing guard entrypoint for the admin body contract line.

The consolidated guard is:

```bash
php tools/interfacing/admin-body-rc-guard.php
```

PowerShell wrapper:

```powershell
powershell -ExecutionPolicy Bypass -File tools/interfacing/admin-body-rc-guard.ps1
```

## What it runs

The consolidated guard orchestrates the existing lower-level checks instead of duplicating them:

- `tools/interfacing/admin-body-mount-contract-guard.php`
- `tools/interfacing/single-ecosystem-base-guard.php`
- `node --check assets/interfacing/admin-body/runtime.js`
- `node --check tools/interfacing/admin-body-runtime-smoke.mjs`
- `node tools/interfacing/admin-body-runtime-smoke.mjs`

## What it protects

- Single ecosystem shell inheritance remains the base model.
- Central admin body mount remains the body integration point.
- Ant Design ProComponents remains the primary admin workbench provider.
- PrimeReact remains the secondary rich-facade provider.
- Twig remains shell, slots, schema, and provider-less path; it is not the final UI system.
- No HostApp copy surface is allowed as the primary integration model.
- No Cruding-specific adapter is allowed in the admin body contract.

## Compatibility note

The wrapper intentionally avoids `[System.IO.Path]::GetRelativePath()` so it remains compatible with older Windows PowerShell / .NET environments.


## Residual cleanup gate

The consolidated RC guard also runs:

```bash
php tools/interfacing/admin-body-residual-audit.php
php tools/interfacing/admin-body-ui-provider-canon-guard.php
- `tools/interfacing/admin-body-frontend-build-guard.php`
```

This keeps removed adapter/copy artifacts out of the RC line, verifies that operator-facing PowerShell wrappers avoid `GetRelativePath` compatibility issues, and keeps the UI provider canon explicit for Codex/local-agent runs.


## RC readiness wrapper

The consolidated guard remains the reusable command set. The promotion gate for `admin-body-rc1` is `tools/interfacing/admin-body-rc-readiness.php`, which calls this consolidated guard and checks the RC readiness documentation markers.


## Strict provider rendering

See `docs/interfacing/interfacing-admin-body-strict-provider-rendering.md`. Admin body UI is provider-required: Ant Design ProComponents renders the primary workbench, PrimeReact remains secondary rich-facade, and Twig publishes only shell/mount/schema/script wiring. Run `npm install`, `npm run ui:build`, and then `php tools/interfacing/admin-body-rc-readiness.php`.

- `tools/interfacing/admin-body-consumer-provider-adoption-audit.php` — audits visible consumer pages for strict provider adoption before component-specific migration waves.

## Consumer adoption runner

The consolidated guard includes `admin-body-consumer-provider-adoption-runner.php` as a non-destructive orchestration entrypoint. Consumer migrations still require each target repository current slice.



## Ecosystem/e-commerce UI coverage

Interfacing maintains an ecosystem-wide page coverage map at `docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md`. Consumer adoption work must compare real pages against this component/page family map instead of treating one repository archive as the whole UI surface. Run `php tools/interfacing/admin-body-ecosystem-ui-coverage-audit.php` before provider adoption waves.


Bridge provider surface: Bridge owns route/resource adoption; Interfacing renders provider-owned UI; direct consumer template rewrite is not the primary path. Guard: `tools/interfacing/admin-body-bridge-provider-surface-guard.php`.

- `admin-body-visible-page-provider-migration-guard.php`

# Interfacing admin body frontend build hardening

This document is the operator-facing build hygiene contract for the strict provider-rendered Interfacing admin body.

The admin body is rendered by canonical frontend providers, not by Bootstrap and not by handmade Twig/CSS:

- Ant Design + ProComponents is the primary admin/workbench provider.
- PrimeReact is the secondary rich-facade provider.
- Twig owns shell slots, mount nodes, schema payloads, and routing integration only.

## Required React line

The current canonical React line is React 18:

- `react`: `^18.3.1`
- `react-dom`: `^18.3.1`

Do not mix React 19 with ReactDOM 18, and do not let `npm install` resolve a cross-major pair. The provider build must have a clean React/ReactDOM major pairing before visual renderer work continues.

## Vite public directory rule

The provider bundle is emitted to:

```text
public/interfacing/admin-body/canonical-providers.js
```

Because the output directory is under Symfony `public/`, Vite must not also treat Symfony `public/` as Vite's own public directory. The Vite config must include:

```ts
publicDir: false
emptyOutDir: true
```

This prevents the warning where `outDir` and `publicDir` overlap.

## Commands

After applying frontend provider changes:

```powershell
npm install
npm run ui:build
php tools/interfacing/admin-body-frontend-build-guard.php
php tools/interfacing/admin-body-ui-provider-canon-guard.php
php tools/interfacing/admin-body-rc-readiness.php
```

For security review, inspect `npm audit` output directly:

```powershell
npm audit
```

Do not run `npm audit fix --force` as an automatic step. Forced audit fixes may upgrade major frontend packages and break the canonical provider line.

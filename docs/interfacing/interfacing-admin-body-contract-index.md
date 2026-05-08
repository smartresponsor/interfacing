# Interfacing Admin Body Contract Index

This is the canonical entrypoint for the Interfacing admin body contract.

The contract is intentionally split into small policies, but consumers should read it as one body discipline:

```text
single ecosystem shell
  -> central admin body mount
      -> schema manifest
      -> provider policy
      -> resource/action/table/form/detail/navigation policies
      -> provider registry and runtime smoke
      -> Twig provider-less UI until the primary provider mounts
```

## Non-negotiable model

- The shell is shared by the ecosystem and is not Cruding-specific.
- The body slot is the only place where admin/business content is rendered.
- `antd-pro` is the primary admin/workbench provider for table/form CRUD surfaces.
- `primereact` is secondary and reserved for rich facade/specialized widgets.
- PrimeReact must not silently replace Ant Design Pro for CRUD/admin body surfaces.
- No HostApp copy/override surface is the primary integration model.
- Twig owns shell, slots, schema payload, and provider-less path; it is not the final design system.
- Composer dependencies must not be used to infer Bootstrap or any other admin body design provider.

## Consumer entrypoints

- UI provider canon: `docs/interfacing/interfacing-admin-body-ui-provider-canon.md`
- UI provider canon guard: `tools/interfacing/admin-body-ui-provider-canon-guard.php`
- Consumer guide: `docs/interfacing/interfacing-admin-body-consumer-guide.md`
- Mount contract: `docs/interfacing/interfacing-admin-body-mount-contract.md`
- Schema manifest: `docs/interfacing/interfacing-admin-body-schema-manifest-contract.md`
- Runtime smoke: `docs/interfacing/interfacing-admin-body-runtime-smoke-harness.md`

## UI provider canon

Local agents must not infer Bootstrap or handmade Twig CSS from Symfony/Twig/composer dependencies. The provider canon is explicit: Ant Design ProComponents is the primary admin/workbench renderer, PrimeReact is secondary/rich-facade, and Twig is only shell/slots/schema/provider-less path. Run `php tools/interfacing/admin-body-ui-provider-canon-guard.php` before changing admin body templates.

## Runtime and provider chain

1. Twig renders `interfacing/admin/body/mount.html.twig` inside the common body slot.
2. Twig embeds `interfacing/admin/body/schema.html.twig` as JSON-like schema payload.
3. `provider-registry.js` creates `InterfacingAdminBodyProviderRegistry`.
4. `providers/antd-pro.js` attaches a real external `InterfacingAntDesignProAdminBodyProvider`, if available.
5. `providers/primereact.js` attaches a real external `InterfacingPrimeReactAdminBodyProvider`, if available.
6. `runtime.js` validates the schema and mounts the primary provider when available.
7. Twig provider-less UI remains visible when the primary provider is missing or validation fails.

## Policy map

| Section | Purpose | Primary provider target |
| --- | --- | --- |
| `schemaManifest` | Versioned table of contents | Runtime validation |
| `providerPolicy` | Provider roles and provider-less path behavior | Runtime selection |
| `resourceContract` | Columns, filters, fields, actions | `ProTable`, `ProForm` |
| `operationPolicy` | CRUD operation placement and delete confirmation | `PageContainer.extra`, `ProTable.actionColumn` |
| `toolbarPolicy` | Search, filters, locale, view mode, bulk actions | `ProTable.toolbar`, `ProTable.search` |
| `rowSelectionPolicy` | Selection and guarded bulk actions | `ProTable.rowSelection` |
| `tableInteractionPolicy` | Pagination, sorting, density | `ProTable.pagination`, `ProTable.options` |
| `emptyStatePolicy` | Empty/loading/error/offline states | `ProTable.locale.emptyText`, `Result`, `Alert` |
| `formLifecyclePolicy` | Save/cancel/reset/dirty state/validation | `ProForm`, `Modal.confirm` |
| `detailViewPolicy` | Show/read-only page layout | `Descriptions`, `ProCard` |
| `navigationPolicy` | Body-local breadcrumbs/context/back action | `PageContainer.breadcrumb` |
| `authorizationPolicy` | UI visibility/disabled/reason semantics | Action renderers, `Tooltip` |
| `telemetryPolicy` | Browser-side UI events only | Runtime/events |
| `accessibilityPolicy` | Landmarks, keyboard, focus, aria-live | Provider-native a11y |
| `responsiveLayoutPolicy` | Desktop/tablet/mobile and density | `ProTable`, `ProForm`, `ProCard` |

## RC interpretation

This index is not another rendering layer. It is the readable table of contents for the already-existing contract surface. Future RC cleanup should consolidate guards and docs around this index rather than adding another adapter or copy workflow.


## Residual audit

Before RC promotion, run the residual audit with:

```bash
php tools/interfacing/admin-body-residual-audit.php
```

This protects the current direction: no Cruding-specific adapter, no HostApp copy/override surface as the primary integration model, and no compatibility-sensitive `GetRelativePath` dependency in operator wrappers.


## RC readiness gate

The RC readiness entrypoint is:

```bash
php tools/interfacing/admin-body-rc-readiness.php
```

This gate marks `admin-body-rc1` only after the consolidated RC guard, residual audit, runtime smoke harness, schema manifest, and documentation index are present and coherent.

## UI provider canon readiness criterion

The RC readiness criteria include `ui-provider-canon-present-and-guarded`. This means `package.json`, provider attachment entrypoints, docs, and guards must expose Ant Design ProComponents as primary admin/workbench provider and PrimeReact as secondary rich-facade provider. The canonical guard is `php tools/interfacing/admin-body-ui-provider-canon-guard.php`.


## Strict provider rendering

See `docs/interfacing/interfacing-admin-body-strict-provider-rendering.md`. Admin body UI is provider-required: Ant Design ProComponents renders the primary workbench, PrimeReact remains secondary rich-facade, and Twig publishes only shell/mount/schema/script wiring. Run `npm install`, `npm run ui:build`, and then `php tools/interfacing/admin-body-rc-readiness.php`.

## Consumer adoption milestone

- `docs/interfacing/interfacing-visible-page-provider-adoption-audit.md` defines the cross-repository visible-page audit for HostHub/App, Cruding, Vendoring, and other consumers.
- `tools/interfacing/admin-body-consumer-provider-adoption-audit.php` scans consumer Twig pages for missing Interfacing admin body provider mounts, Bootstrap-like drift, handmade Twig admin tables/forms, and removed Cruding adapter/copy surfaces.

## Visible page provider adoption runner

Use `tools/interfacing/admin-body-consumer-provider-adoption-runner.php` to scan sibling consumer repositories such as `../App`, `../Cruding`, and `../Vendoring` after the Interfacing contract is applied. The runner produces one consolidated report and keeps consumer migration work factual.


visible-page-provider-adoption-runner


## Ecosystem/e-commerce UI coverage

Interfacing maintains an ecosystem-wide page coverage map at `docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md`. Consumer adoption work must compare real pages against this component/page family map instead of treating one repository archive as the whole UI surface. Run `php tools/interfacing/admin-body-ecosystem-ui-coverage-audit.php` before provider adoption waves.

## Frontend build hardening

The strict provider-rendered admin body requires a clean frontend build line:

- React and ReactDOM stay on `^18.3.1`.
- Vite uses `publicDir: false` because the provider bundle is emitted under Symfony `public/`.
- The canonical provider bundle is `public/interfacing/admin-body/canonical-providers.js`.
- Operators use `npm run ui:build` and inspect `npm audit`; they do not run `npm audit fix --force` automatically.

See `docs/interfacing/interfacing-admin-body-frontend-build-hardening.md`.

- `frontend-build-hardened-react18-vite-publicdir-disabled`


Bridge provider surface: Bridge owns route/resource adoption; Interfacing renders provider-owned UI; direct consumer template rewrite is not the primary path. Guard: `tools/interfacing/admin-body-bridge-provider-surface-guard.php`.

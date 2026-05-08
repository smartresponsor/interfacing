# Interfacing admin body residual audit cleanup

This document closes the residual-cleanup part of the admin body RC tail.
It does not introduce a new layout, provider, bridge, or visual rendering layer.
Its purpose is to keep the current line clean before RC promotion.

## Residual audit gate

This section is the canonical Residual audit entrypoint for the RC tail.

## Guard

Run the audit directly:

```bash
php tools/interfacing/admin-body-residual-audit.php
```

Or through the consolidated RC guard:

```bash
php tools/interfacing/admin-body-rc-guard.php
```

## What the residual audit protects

The audit verifies that the Interfacing admin body line still has:

- one ecosystem shell;
- one central admin body mount;
- Ant Design ProComponents as the primary admin/workbench provider;
- PrimeReact as the secondary rich-facade provider;
- Twig provider-less UI for no-provider/no-JavaScript states;
- no Cruding-specific adapter;
- no HostApp copy surface as the primary integration model;
- no `GetRelativePath` dependency in operator-facing PowerShell wrappers.

## Forbidden residual artifacts

The following artifacts must not return:

- `template/interfacing/crud/bridge/cruding_host_adapter.html.twig`
- `template/interfacing/crud/host_shell_adapter.html.twig`
- `pack/templates/bundles/CrudingBundle`
- `src/Contract/Crud/InterfacingCrudShellTemplateContract.php`
- `tools/interfacing/cruding-host-shell-pack-guard.php`
- `tools/interfacing/cruding-host-shell-pack-guard.ps1`
- `docs/interfacing/interfacing-cruding-bridge-adoption.md`
- `docs/interfacing/interfacing-cruding-host-override-pack.md`
- `docs/interfacing/interfacing-cruding-host-shell-pack-guard.md`

## RC implication

After this cleanup wave, new work should be RC hardening only: runtime smoke,
static guards, documentation index consistency, and release/readiness markers.
Do not reintroduce adapter/copy paths to solve normal CRUD body rendering.

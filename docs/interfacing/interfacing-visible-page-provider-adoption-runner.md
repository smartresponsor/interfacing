# Interfacing visible page provider adoption runner

This document defines the multi-consumer runner for the visible-page provider adoption milestone.

The single-consumer audit checks one repository. The runner coordinates that audit across sibling consumer repositories such as HostHub/App, Cruding, and Vendoring, then writes one consolidated report.

## Purpose

Interfacing owns the canonical provider contract:

- Ant Design ProComponents is the primary admin/workbench provider.
- PrimeReact is the secondary rich-facade provider.
- Twig is not an admin design system.
- Bootstrap is not an approved design provider.
- Cruding is not special-cased with adapters or HostApp copy overrides.

Consumer repositories own their visible pages. The runner exists so a local operator or Codex-style agent can quickly see which visible pages still need migration to the Interfacing provider-owned body.

## Command

```powershell
php tools/interfacing/admin-body-consumer-provider-adoption-runner.php `
  --consumer-root=../App `
  --consumer-root=../Cruding `
  --consumer-root=../Vendoring `
  --format=markdown `
  --output=var/interfacing-visible-page-provider-adoption-runner.md
```

For strict migration gates:

```powershell
php tools/interfacing/admin-body-consumer-provider-adoption-runner.php `
  --consumer-root=../Cruding `
  --strict
```

The `--defaults` flag scans the standard sibling candidates when they exist:

- `../App`
- `../HostHub`
- `../Cruding`
- `../Vendoring`

Missing default roots are reported as skipped unless `--require-existing` is passed.

## Expected migration signal

A consumer page is not ready when it still:

- misses `interfacing/admin/body/mount.html.twig`;
- renders handmade Twig table/form admin UI;
- contains inline admin `<style>`;
- contains Bootstrap-like classes such as `btn btn-`, `container-fluid`, or `class="row"`;
- references removed Cruding adapter or HostApp copy surfaces.

The runner does not migrate consumers by itself. It creates the report that drives the next per-repository current-slice migration wave.

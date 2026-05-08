# Interfacing visible page provider adoption audit

## Purpose

This document starts the consumer-adoption milestone for visible pages. Interfacing already owns the strict provider canon. HostHub/App, Cruding, Vendoring, and other component pages must now adopt that canon instead of rendering local Twig/CSS admin pages.

## Canonical rendering chain

```text
shared ecosystem shell
  -> Interfacing admin body mount
      -> Ant Design ProComponents primary admin/workbench provider
      -> PrimeReact secondary rich-facade provider
```

Twig may publish shell inheritance, provider mount metadata, schema payloads, and script wiring. Twig must not be treated as the admin design system.

## Forbidden consumer directions

Consumer repositories must not introduce or preserve these directions as visible admin UI:

- Bootstrap or Bootstrap-like admin body classes as the design provider.
- Handmade Twig tables/forms/CSS as the primary CRUD body.
- Cruding-specific shell adapters.
- HostApp copy/override surfaces for `templates/bundles/CrudingBundle` as the integration model.
- Provider-less admin pages that silently keep old UI.

## Audit command

Run from the Interfacing repository:

```powershell
php tools/interfacing/admin-body-consumer-provider-adoption-audit.php --consumer-root=../Cruding --strict
php tools/interfacing/admin-body-consumer-provider-adoption-audit.php --consumer-root=../App --consumer-root=../Vendoring --format=markdown --output=var/interfacing-visible-page-provider-adoption-audit.md
```

The PowerShell wrapper is available as:

```powershell
powershell -ExecutionPolicy Bypass -File tools/interfacing/admin-body-consumer-provider-adoption-audit.ps1 `
  -ConsumerRoot ../Cruding `
  -Format markdown `
  -Output var/interfacing-visible-page-provider-adoption-audit.md `
  -Strict
```

## Expected migration result

Each visible admin/workbench page should either be outside the admin body domain or expose the Interfacing admin body provider mount. For CRUD pages, the correct migration is to stop rendering local tables/forms in Twig and pass resource schema into the canonical provider-owned admin body.

## Milestone scope

The next repository-specific waves should use this audit to drive migration in these consumers:

- HostHub/App visible pages.
- Cruding list/detail/new/edit/delete pages.
- Vendoring visible pages.
- Other Smart Responsor component landing/admin pages.

This document does not claim that those repositories have already migrated. It is the gate and checklist that prevents future local agents from continuing Bootstrap-like or handmade Twig admin UI.

## Multi-consumer runner

Use `tools/interfacing/admin-body-consumer-provider-adoption-runner.php` when the operator needs one report across sibling repositories. The runner delegates the actual template checks to this audit tool and does not migrate consumers by itself.

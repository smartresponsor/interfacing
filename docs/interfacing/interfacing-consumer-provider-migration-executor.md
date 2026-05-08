# Interfacing consumer provider migration executor

This tool is no longer the normal migration path.

Bridge owns route/resource adoption. Interfacing renders provider-owned UI. Direct consumer template rewrite is not the primary path.

Use this executor for audit/dry-run output and for explicit local repair only. A write requires both:

```text
--apply --force-direct-template-rewrite
```

Normal visible UI migration should be implemented through the bridge provider surface:

```text
template/interfacing/bridge/provider_surface.html.twig
```

# Interfacing consumer provider migration executor

This tool is the practical migration step after the visible page adoption
runner. It rewrites known consumer visible Twig pages from handmade/admin Twig UI
into canonical Interfacing provider page entries.

## Canon

Consumer pages must not keep their own primary admin UI renderer:

- no handmade admin tables;
- no handmade admin forms;
- no inline admin CSS;
- no Bootstrap-like classes as the page rendering contract;
- no component-local shell as a substitute for the ecosystem shell;
- no HostApp copy/override surface.

The page-level output must enter:

```text
interfacing/admin/body/provider_page.html.twig
```

That provider page mounts Ant Design ProComponents as the primary
admin/workbench renderer and PrimeReact as the secondary rich-facade provider.

## Dry run

From the Interfacing repository:

```powershell
php tools/interfacing/admin-body-consumer-provider-migration-executor.php `
  --consumer-root="../Cataloging" `
  --consumer-root="../Cruding" `
  --consumer-root="../Vendoring" `
  --format=markdown `
  --output="var/interfacing-consumer-provider-migration-executor.md"
```

## Apply

```powershell
php tools/interfacing/admin-body-consumer-provider-migration-executor.php `
  --consumer-root="../Cataloging" `
  --consumer-root="../Cruding" `
  --consumer-root="../Vendoring" `
  --apply `
  --format=markdown `
  --output="var/interfacing-consumer-provider-migration-executor.md"
```

## Macro templates

Macro files are not rewritten by default because callers can depend on exact
macro names. For the current known offender:

```text
../Vendoring/templates/_macros/crud.html.twig
```

use `--include-macros` only when caller compatibility is verified.

## Verification

After applying consumer migration, run:

```powershell
php tools/interfacing/admin-body-consumer-provider-adoption-runner.php `
  --consumer-root="../App" `
  --consumer-root="../Cataloging" `
  --consumer-root="../Cruding" `
  --consumer-root="../Vendoring" `
  --format=markdown `
  --output="var/interfacing-consumer-visible-page-adoption-report.md"

php tools/interfacing/admin-body-rc-readiness.php
npm run ui:build
```

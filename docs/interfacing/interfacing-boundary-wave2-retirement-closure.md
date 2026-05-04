# Interfacing Boundary Wave 2: Retirement Closure

## Purpose

Close high-risk structural drift without changing the active shell, CRUD, screen, or provider business behavior.

## Active source boundary

The active PHP runtime remains under `src/`. The active Twig runtime remains under `template/`.

## Closed duplicate Symfony entrypoints

The component has one canonical Symfony bundle and one canonical DI extension:

- `src/InterfacingBundle.php`
- `src/DependencyInjection/InterfacingExtension.php`

The duplicate package-era entrypoints under `src/Integration/Symfony` are retired. The `Integration/Symfony`
folder remains valid for attributes and compiler passes only.

## Closed root donors

The following root-level donor files were retired because their active canonical equivalents already exist under
`src/` or `template/`:

- `CrudRouteContext.php`
- `CrudWorkbenchFactory.php`
- `base.html.twig`
- `crud/screen.html.twig`
- `crud/workbench_base.html.twig`
- `templates/base.html.twig`

## Twig path canon

`template/` is the canonical Twig root for Interfacing. The secondary `templates/` path is no longer registered
by the Interfacing overlay config.

## Non-goals

This wave does not decompose controllers, collapse duplicated service interfaces, remove `pack/src`, or rewrite
CRUD runtime semantics. Those belong to later waves after the active source boundary is stable.

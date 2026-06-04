# Interfacing host CRUD shell contract

## Purpose

Interfacing owns the shared Smart Responsor UI shell for the host ecosystem. The
shell owns the top menu, left panels, right context panel, quick menu, footer
menu, and the central body slot.

CRUD pages are not a special shell family. They render normal page content into
the central body slot of the same base used by all connected applications.

## Canonical inheritance

```text
component or Interfacing page template
  -> base.html.twig
  -> shell/base.html.twig
```

For Interfacing-local templates the explicit equivalent is:

```text
interfacing/... page template
  -> base.html.twig
  -> shell/base.html.twig
```

For the generic CRUD workbench preview owned by Interfacing:

```text
crud/generic.html.twig
  -> crud/screen.html.twig
  -> crud/workbench_base.html.twig
  -> base.html.twig
  -> shell/base.html.twig
```

## Rule

There is no Cruding-specific adapter, no host-copy pack, and no generated bundle
override surface in Interfacing. Cruding and every other connected application
should resolve to the same base shell and fill only the body/content block.

The generic bridge must not render an order-specific template such as
`order/summary.html.twig`.

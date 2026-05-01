# Interfacing admin surface discipline

This wave standardizes the shell-native admin surface for CRUD discovery, screen directory and operation workbench pages.

## Rules

- All admin-like pages extend `interfacing/base.html.twig`.
- Page headers use the shared admin toolbar partial.
- CRUD route grammar is displayed from one shared partial.
- Status language is consistent: `connected`, `canonical`, `planned`.
- Interfacing may expose navigation probes and empty/action states, but must not invent business rows or component fixture records.
- Show/edit/delete sample links are sample probes only; real identifiers come from the owning component.

## Canonical CRUD grammar

```text
/{resourcePath}/
/{resourcePath}/new/
/{resourcePath}/{id|slug}
/{resourcePath}/edit/{id|slug}
/{resourcePath}/delete/{id|slug}
```

## Current scope

This is a UI transparency wave. It does not delete demo files and does not move business data. It reduces opacity by making the workbench, screen directory and CRUD explorer share the same header, route guide and status legend.

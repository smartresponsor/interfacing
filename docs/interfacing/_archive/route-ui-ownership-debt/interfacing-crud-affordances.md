# Interfacing CRUD affordances

The CRUD affordances surface exposes shell-native controls for search, filters, sorting, pagination and bulk actions across all known Smart Responsor e-commerce CRUD resources.

## Boundary

Interfacing owns only the admin chrome, route transparency and control placement. Owning components provide:

- searchable fields;
- filter operators;
- allowed sort keys;
- pagination semantics;
- selectable identifiers;
- bulk operation handlers;
- authorization and audit evidence;
- records and fixtures.

No demo rows, fake filter results or business fixtures should be seeded from Interfacing.

## Canonical surface

```text
/interfacing/affordances
```

The surface is generated from the same canonical CRUD registry used by Admin Tables and CRUD Frames.

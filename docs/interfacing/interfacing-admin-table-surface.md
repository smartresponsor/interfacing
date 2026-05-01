# Interfacing Admin Table Surface

The admin table surface is a shell-native index/table view for every known CRUD resource in the Smart Responsor e-commerce ecosystem.

## Contract

Interfacing owns:

- table chrome;
- empty-state wording;
- index/new/show/edit/delete action affordances;
- canonical CRUD URL grammar visibility;
- `connected`, `canonical`, and `planned` status presentation.

Owning components own:

- records;
- fixtures;
- identifiers;
- permissions;
- domain validation;
- destructive command handling.

## Route

```text
/interfacing/tables
```

## Boundary

The page must not seed or mirror business demo rows. It is intentionally table-first and metadata-driven, so planned components can be visible before host integration without pretending that Interfacing stores their data.

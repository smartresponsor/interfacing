# Interfacing CRUD Operation Launchpad

W6 adds an operation-oriented export for the CRUD Explorer.

The purpose is to compensate for the default EasyAdmin navigation surface without moving ownership of business persistence into Interfacing.

## Endpoint

```text
/interfacing/crud/explorer/operations.json
```

The endpoint groups all known Smart Responsor CRUD resources by operation:

- `index`
- `new`
- `show`
- `edit`
- `delete`

Each operation entry carries the bridge route name, route grammar, and resource links generated from the same CRUD bridge used by the visible explorer.

## Boundary

Interfacing owns the workbench shell, route grammar visibility, operation launchpad, JSON exports, and quick navigation links.

The owning component still owns persistence, validation, domain rules, destructive action execution, and component-specific controllers when those controllers exist.

## Expected use

Use the operation launchpad when validating that a host application exposes an equivalent action surface to the old EasyAdmin default experience:

- all resources have index and new links;
- all resources expose sample show/edit/delete links;
- planned resources are visible before their host component is fully connected;
- scripts can compare operation-level coverage from the JSON export.

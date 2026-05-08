# Interfacing admin body table interaction policy contract

The admin body workbench is table-first. Pagination, sorting, and density controls are explicit ProTable concerns rather than ad hoc Twig links or bespoke JavaScript behavior.

## Canonical policy

- `pagination.mode`: `server-driven`
- `pagination.providerTarget`: `ProTable.pagination`
- `sorting.mode`: `server-driven`
- `sorting.providerTarget`: `ProTable.columns.sorter`
- `density.providerTarget`: `ProTable.options`
- Sort directions are limited to `asc` and `desc`.
- Density options are `small`, `middle`, and `large`.

Twig may keep a provider-less rendering path, but the interactive admin body renderer should consume `tableInteractionPolicy` from the JSON schema.

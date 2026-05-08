# Interfacing admin body row-selection policy contract

Wave 16 adds an explicit row-selection policy for the central admin body workbench.

The toolbar may expose a bulk-action region, but bulk actions are valid only when they are guarded by the row-selection policy. This prevents CRUD screens from rendering destructive mass actions as loose buttons in the body toolbar.

## Canon

- Ant Design ProComponents remains the primary admin/workbench renderer.
- Row selection maps to `ProTable.rowSelection`.
- Bulk actions map to `ProTable.tableAlertOption` and `ProTable.tableAlertOption.bulkActions`.
- Destructive bulk actions require confirmation.
- Twig provider-less UI may show the control state, but it must not implement an independent bulk-action UI system.

## Required schema key

`rowSelectionPolicy` is a top-level admin body schema key with:

- `name`
- `version`
- `enabled`
- `rowKey`
- `selectionType`
- `mode`
- `bulkActions`
- `providerTargets`

The canonical mode is `guarded-by-row-selection`.

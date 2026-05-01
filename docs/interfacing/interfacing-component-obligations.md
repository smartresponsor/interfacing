# Interfacing component obligations

The component obligations surface is a shell-native checklist at `/interfacing/obligations`.

It exists to keep the Interfacing component transparent: Interfacing may render navigation, chrome, route grammar, CRUD frames and operator affordances, but it must not invent business rows, fixtures or component-owned records.

## Ownership boundary

For each Smart Responsor component, the owning component must provide:

- fixtures or runtime providers;
- canonical identifiers and sample identifiers for smoke navigation;
- field schema, validation and read-only rules;
- index columns, filters, sort keys and pagination contract;
- new/edit/show/delete handlers;
- authorization and destructive-operation policy;
- audit evidence and runtime smoke proof.

Interfacing owns only:

- shell layout;
- topbar, left navigation and footer;
- route-transparent CRUD links;
- admin tables, form frames and affordance frames;
- empty/loading/error states;
- status and obligation reporting.

## Risk levels

- `high` means a component is still planned and must not be treated as runtime connected.
- `medium` means canonical route grammar exists, but host/controller binding and component-owned data are still needed.
- `low` means the shell surface exists, but component runtime proof and permission-aware action disabling still need validation.

The page intentionally contains no business demo rows.

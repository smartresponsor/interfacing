# Interfacing CRUD bridge audit — 2026-05-01

## Findings

- The current slice already has a strong CRUD resource registry and explorer, but `AbstractCrudResourceContribution` generated `app_crud_index` and `app_crud_new` route names that were not declared in the slice.
- Because those route names were missing, the explorer had to rely on text fallback URLs. That made the links look correct, but they were not backed by a Symfony route bridge.
- The shell needs a fast EasyAdmin-style compensation layer: index, new, show, edit and delete screens must open from the address bar using the same CRUD grammar, even before all owning components are connected.

## Patch decision

This wave adds a generic preview bridge for known Smart Responsor resources:

- `/{resourcePath}/`
- `/{resourcePath}/new/`
- `/{resourcePath}/{id}`
- `/{resourcePath}/edit/{id}`
- `/{resourcePath}/delete/{id}`

The bridge renders the existing CRUD workbench with sample rows. It does not claim persistence ownership and does not replace component-owned controllers. Component-specific routes should still win when they exist.

## Boundary

Interfacing owns the shell, navigation, route grammar preview, table/form/destructive frames and discoverability. The owning components still own entities, validation, persistence, authorization depth and real command handling.

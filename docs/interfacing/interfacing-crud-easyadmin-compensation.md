# Interfacing CRUD EasyAdmin compensation

This wave turns the CRUD Explorer into the fast navigation surface normally expected from a default admin generator.

## Canonical behavior

Every listed resource exposes the same operation set:

- `Index` → `/{resourcePath}/`
- `New` → `/{resourcePath}/new/`
- `Show` → `/{resourcePath}/{id}`
- `Edit` → `/{resourcePath}/edit/{id}`
- `Delete` → `/{resourcePath}/delete/{id}`

The URLs are generated through the same generic bridge route names used by the Interfacing workbench: `app_crud_index`, `app_crud_new`, `app_crud_show`, `app_crud_edit`, and `app_crud_delete`.

## Boundary

Interfacing owns the shell, table, form, command affordances, and navigation directory. It does not claim business persistence from the owning components. A URL may resolve to the generic preview bridge before the target component is connected to the host application.

## Drift corrected

The explorer previously rendered operation buttons, but there was no reusable operation matrix contract on the resource link set itself. This made it easy for future Twig screens to drift by hardcoding different action lists. `CrudResourceLinkSetInterface::operationUrls()` is now the stable source for Index/New/Show/Edit/Delete navigation.

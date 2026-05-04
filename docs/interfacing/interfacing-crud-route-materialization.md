# Interfacing CRUD route materialization

This wave closes the second CRUD directory drift: `Index` and `New` were generated through the generic Symfony CRUD routes, but sample `Show`, `Edit`, and `Delete` links were previously materialized from static string patterns.

The explorer now stores route-generated sample URLs for all five CRUD operations:

- `app_crud_index` -> `/{resourcePath}/`
- `app_crud_new` -> `/{resourcePath}/new/`
- `app_crud_show` -> `/{resourcePath}/{id}`
- `app_crud_edit` -> `/{resourcePath}/edit/{id}`
- `app_crud_delete` -> `/{resourcePath}/delete/{id}`

The string patterns remain visible in the UI as grammar documentation, but clickable links are produced through `UrlGeneratorInterface` when the route bridge is present.

## Boundary

Interfacing still does not own persistence for these resources. This component provides the shell-native compensation for Easy Admin-style navigation: route-compatible index, create, inspect, edit, and delete workbench frames across connected, canonical, and planned Smart Responsor resources.

Owning components remain responsible for concrete persistence, validation, permissions, actions, and durable business behavior.

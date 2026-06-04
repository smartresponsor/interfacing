# Interfacing controller wave 11 — dynamic screen route extraction

Wave 11 closes the remaining mixed responsibility in `InterfaceController`.

## Decision

`InterfaceController` owns static/workspace Interfacing pages only.

`InterfaceDynamicScreenController` owns dynamic screen runtime routes:

- `/interfacing/{id}`
- retired `/interfacing/{id}` compatibility path; canonical screen rendering is `/interfacing/{id}`

## Canonical flow

Dynamic screen requests must use this chain:

1. Symfony route controller receives the route id.
2. `InterfaceScreenViewBuilderInterface` builds the render context.
3. `InterfaceRendererInterface` renders `page/screen.html.twig`.
4. `InterfaceScreenNotFound` maps to 404.
5. `InterfaceScreenForbidden` maps to 403.

## Boundary

Controllers must not directly assemble layout catalogs, runtime screen registries, screen contexts, or capability access checks for dynamic screens. That orchestration belongs to the view-builder service layer.

## Compatibility

Route names remain unchanged:

- `interfacing_screen`
- retired `interfacing_screen_legacy`

The public URL surface is unchanged.

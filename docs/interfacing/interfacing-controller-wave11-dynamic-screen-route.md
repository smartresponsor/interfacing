# Interfacing controller wave 11 — dynamic screen route extraction

Wave 11 closes the remaining mixed responsibility in `InterfacingController`.

## Decision

`InterfacingController` owns static/workspace Interfacing pages only.

`DynamicScreenController` owns dynamic screen runtime routes:

- `/interfacing/{id}`
- `/interfacing/screen/{id}` as legacy compatibility

## Canonical flow

Dynamic screen requests must use this chain:

1. Symfony route controller receives the route id.
2. `ScreenViewBuilderInterface` builds the render context.
3. `InterfacingRendererInterface` renders `interfacing/page/screen.html.twig`.
4. `ScreenNotFound` maps to 404.
5. `ScreenForbidden` maps to 403.

## Boundary

Controllers must not directly assemble layout catalogs, runtime screen registries, screen contexts, or capability access checks for dynamic screens. That orchestration belongs to the view-builder service layer.

## Compatibility

Route names remain unchanged:

- `interfacing_screen`
- `interfacing_screen_legacy`

The public URL surface is unchanged.

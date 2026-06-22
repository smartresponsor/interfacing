# Render entrypoint index-only canon

Interfacing uses `templates/base.html.twig` as the only document-level shell.
Surface-level `base.html.twig` files are allowed only as thin inheritance adapters.
They must not be treated as visible renderer endpoints.

## Runtime lookup rule

A producer or renderer may resolve a view through concrete visible templates only:

1. `templates/<view>/<operation>.html.twig`
2. `templates/<view>/index.html.twig`
3. data-only handoff when no visible template exists

The resolver must not fall through to `templates/<view>/base.html.twig`.
A view base can be extended by concrete templates, but rendering it directly is
ambiguous because it mixes layout inheritance with screen ownership.

## Naming rule

- `index.html.twig` means the default visible view endpoint.
- `surface.html.twig`, `show.html.twig`, `form.html.twig`, and similar files are concrete screen variants.
- `base.html.twig` means inheritance adapter only.

## Gate rule

`composer canon:interfacing` forbids direct view-base render targets in active
PHP/config runtime declarations, while still allowing Twig templates to extend a
view adapter.


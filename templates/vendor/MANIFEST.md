# vendor surface templates

This directory is an Interfacing UI surface tree named after the business noun `vendor`.

Vendoring owns the profile payload. Interfacing owns the slot-driven layout that
renders those payloads into the canonical shell contract.

## Canonical entries

- `template/base.html.twig` - canonical root fallback base for vendor payload JSON.
- `template/vendor/index.html.twig` - vendor landing surface.
- `template/vendor/profile/show.html.twig` - vendor public profile surface.

## Slot contract

The vendor surface may pass payload only to these public content-output shell locations:

- `shell.body.top`
- `shell.left.top`
- `shell.left.middle`
- `shell.left.bottom`
- `shell.context.top`
- `shell.context.middle`
- `shell.context.bottom`
- `shell.main.top`
- `shell.main.toolbar`
- `shell.main.content`
- `shell.main.bottom`
- `shell.right.top`
- `shell.right.tool`
- `shell.right.filter`
- `shell.right.middle`
- `shell.right.bottom`
- `shell.footer.top`
- `shell.footer.left`
- `shell.footer.context`
- `shell.footer.main`
- `shell.footer.right`
- `shell.header.bottom`

Header brand/search/menu points are provider-owned anchors and are not vendor payload locations.

## Provider policy

- Ant Design ProComponents remains the primary provider vocabulary for workbench-like detail surfaces.
- PrimeReact remains the secondary rich-facade provider vocabulary.
- Twig owns structure, slot placement, and fallback rendering.
- Vendor surfaces may render plain data when a richer provider widget is unavailable.

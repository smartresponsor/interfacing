# Canonical location-only shell payload

Interfacing now treats the semantic shell location map as canonical-only runtime input.
The document base, provider navigation templates and diagnostics read these public output keys directly:

- `shell.body.top`
- `shell.header.bottom`
- `shell.left.top|middle|bottom`
- `shell.context.top|middle|bottom`
- `shell.main.top|toolbar|content|bottom`
- `shell.right.top|tool|filter|middle|bottom`
- `shell.footer.top|left|context|main|right`

Retired aliases such as `shell.left.primary`, `shell.left.section`, `left.primary.menu`,
`body.header`, `right.context`, and `footer.primary` must not be reintroduced in active
runtime source. Producer components must normalize payloads before handing them to
Interfacing. Header brand/search/menu internals are provider markup, not payload locations.

Navigation is provider-native only. The retired `templates/navigation/tree.html.twig` file
must not return; menus should be mounted through `templates/navigation/provider.html.twig`
and provider baseline classes.

Direct business short routes such as `/billing/meter` and `/order/summary` are no longer
registered by Interfacing. Interfacing-owned screens remain under `/interfacing/...`; owning
business components may expose their own customer-facing routes separately.


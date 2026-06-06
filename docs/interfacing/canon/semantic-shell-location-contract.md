= Semantic Shell Location Contract

Canonical machine-readable source: `config/interfacing/shell_location.yaml`.

Stable public output locations:

* `shell.body.top`
* `shell.left.top|middle|bottom`
* `shell.context.top|middle|bottom`
* `shell.main.top|toolbar|content|bottom`
* `shell.right.top|tool|filter|middle|bottom`
* `shell.footer.top|left|context|main|right`
* `shell.header.bottom`

Producer components must publish location payloads only to these keys. Header brand/search/menu internals are provider markup and must not be exposed as `shell.header.*` payload anchors. Interfacing no longer reads legacy alias keys in the root document base, navigation map, layout preview, panel diagnostics, or footer partials.

Retired examples:

* `shell.left.primary`
* `shell.left.section`
* `left.primary.menu`
* `body.content`
* `right.context`
* `footer.primary`

These aliases may be mentioned in migration notes only. They must not return in active `src/`, `config/`, or `templates/` runtime source.


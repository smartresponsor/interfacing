= Semantic Shell Location Contract

Canonical machine-readable source: `config/interfacing/shell_location.yaml`.

Stable root namespaces:

* `shell.body.top`
* `shell.header.*`
* `shell.left.*`
* `shell.context.*`
* `shell.main.*`
* `shell.right.*`
* `shell.footer.*`

Producer components must publish location payloads only to these keys. Interfacing no longer reads legacy alias keys in the root document base, navigation map, layout preview, panel diagnostics, or footer partials.

Retired examples:

* `shell.left.primary`
* `shell.left.section`
* `left.primary.menu`
* `body.content`
* `right.context`
* `footer.primary`

These aliases may be mentioned in migration notes only. They must not return in active `src/`, `config/`, or `templates/` runtime source.


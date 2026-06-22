# View base thin adapter canon

Wave 3 locks the local view base convention.

`templates/base.html.twig` is the only document-level base. A view-level
`templates/<view>/base.html.twig` may exist only as a thin adapter that extends
`@Interfacing/base.html.twig` and exposes a small local body block for concrete
pages.

Visible provider/workbench markup belongs in a concrete page template such as
`templates/<view>/surface.html.twig`, not in the local `base.html.twig`.

This keeps noun/view folders useful while preventing parallel document bases,
local mini-shells, or component-name template roots.

## Gate

The repository-level drift gate enforces this rule through:

```bash
composer canon:interfacing
```

A view base that does not extend `@Interfacing/base.html.twig`, or one that renders a second `<!DOCTYPE html>` / `<html>` document shell, fails the gate.


# Interfacing base shell standard audit

## Objective
Unify user-facing pages under one base shell standard: top bar, primary navigation, section navigation, content area and footer.

## Canon
- User-facing HTML pages must render through `InterfaceRendererInterface`.
- User-facing Twig pages must extend `base.html.twig` unless they are small partials/components.
- Legacy screen hosts may remain, but they must still render inside the same base shell.

## Cleanup applied
- Doctor pages normalized into base shell.
- Legacy shell demo pages normalized into base shell.
- Controllers moved from direct Twig rendering to `InterfaceRendererInterface` where needed.
- Conflicting `/interfacing` demo shell route moved to `/interfacing/shell-demo`.
- The retired shell-legacy route has been removed; shell diagnostics live under `/interfacing/shell/*` and the demo page lives at `/interfacing/shell-demo`.
- Visible shell pages now render directly and no longer rely on the retired workspace builder contract.

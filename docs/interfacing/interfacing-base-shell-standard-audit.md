# Interfacing base shell standard audit

## Objective
Unify user-facing pages under one base shell standard: top bar, primary navigation, section navigation, content area and footer.

## Canon
- User-facing HTML pages must render through `InterfacingRendererInterface`.
- User-facing Twig pages must extend `interfacing/base.html.twig` unless they are small partials/components.
- Legacy screen hosts may remain, but they must still render inside the same base shell.

## Cleanup applied
- Doctor pages normalized into base shell.
- Legacy shell demo pages normalized into base shell.
- Controllers moved from direct Twig rendering to `InterfacingRendererInterface` where needed.
- Conflicting `/interfacing` demo shell route moved to `/interfacing/shell-demo`.
- Legacy shell route moved to `/interfacing/shell-legacy`.

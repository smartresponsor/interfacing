# Interfacing host-wide shell contract

This wave moves the shared Smart Responsor shell from an Interfacing-local page concern to the application-wide Twig base layout.

## Canonical behavior

Every page that extends `base.html.twig` receives the shared chrome:

- top panel with a visible filter toolbar;
- primary left panel;
- secondary left panel;
- content body;
- optional right context panel;
- footer.

The default mode is four-column: primary left, secondary left, body and right context. A page may pass `shell.rightPanelEnabled = false` to render the three-column mode. Top and footer remain mandatory in both modes.

## Fallback context

The base layout renders a safe fallback navigation set when a controller does not pass a `shell` variable. This is intentional: host pages must not lose the shell merely because they are not Interfacing diagnostic pages.

When a controller passes `shell` from `ShellChromeProvider`, those groups override the fallback groups.

## Boundaries

Interfacing owns visual shell/chrome and generic CRUD navigation affordances. Owning components still own their business persistence, validation and component-specific controllers.

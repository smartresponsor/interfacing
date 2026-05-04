Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

# Interfacing shared shell panels

This corrective wave standardizes the shell chrome used by Interfacing screens.

The shared base template now provides these stable zones:

- `shell.topbar.left` and `shell.topbar.right` for the global top panel.
- `shell.nav.primary` for the first left navigation column.
- `shell.nav.section` for the second left navigation column.
- `shell.content.body` for the main screen body.
- `shell.content.aside` for the right contextual panel.
- `shell.footer.primary` and `shell.footer.secondary` for the shared footer.

Default layout mode is four-column:

```text
Top panel
Primary left | Section left | Body | Right context
Footer
```

A screen can opt into the three-column mode by passing `shellRightPanelEnabled = false` while still keeping the mandatory top panel and footer:

```text
Top panel
Primary left | Section left | Body
Footer
```

The shared panels are implemented as Twig partials under `template/interfacing/shell/partial/` so CRUD screens, launchpads, diagnostics, screen directories and component workbenches use the same shell chrome instead of per-page fragments.

The workspace home also exposes component/entity CRUD quick links generated from the canonical screen matrix. Connected, canonical and planned resources are all visible so operators can click real CRUD bridge URLs even before every owning component is fully connected in the host application.

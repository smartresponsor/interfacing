# Interfacing shell panels W9

W9 strengthens the shared Interfacing shell so every shell-rendered screen receives the same operator chrome:

- top panel;
- primary left panel;
- secondary left panel;
- central body panel;
- optional right context panel;
- footer panel.

The default shell mode is now the four-column operator layout: two left navigation rails, body, and right context rail. A page may still opt into the three-column mode by setting `shell.rightPanelEnabled` to `false`, but the top panel and footer remain mandatory.

The right panel intentionally exposes known Smart Responsor component/entity CRUD links, including connected and planned resources. This keeps the main screen useful even when a host application has not wired every component yet. Links use the generic CRUD bridge grammar instead of placeholder-only navigation.

The reusable Twig partials live under `template/interfacing/shell/partial/` and are included by `template/interfacing/base.html.twig`.

# Interfacing shell panel diagnostics

W11 adds a runtime-visible guard for the shared Interfacing shell contract.

The default shell must expose:

- Top panel.
- Primary left panel.
- Secondary left panel.
- Body/content panel.
- Right context panel in default four-column mode.
- Footer panel.

The diagnostic page is available at `/interfacing/shell/diagnostics` and the machine-readable export is available at `/interfacing/shell/diagnostics.json`.

This is intentionally a shell/chrome guard. It does not move business persistence into Interfacing and does not replace owning component CRUD handlers. It makes drift visible when future screens bypass the shared base template or when provider output stops populating required panels.

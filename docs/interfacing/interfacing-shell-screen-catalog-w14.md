# Interfacing shell screen catalog W14

W14 adds a single shell-level screen catalog for the Interfacing workbench.

The catalog is intentionally broader than the existing ecommerce screen directory. It includes:

- shell navigation screens;
- diagnostics and JSON exports;
- application dashboard links;
- CRUD bridge screens for every known Smart Responsor resource;
- planned resources that are not yet wired into the host application.

Routes:

- `/interfacing/shell/screens`
- `/interfacing/shell/screens.json`

This keeps the EasyAdmin replacement visible through the common shell. Any page exposed from this catalog must render with the shared Top, left primary, left secondary, body, optional right context, and footer panels.

# Interfacing shell navigation map W12

W12 adds a dedicated shared-shell navigation map so the common panels are visible as a first-class contract, not only as layout chrome.

## Endpoints

- `/interfacing/shell/navigation` renders the visual link map.
- `/interfacing/shell/navigation.json` exports the same map for smoke checks.

## Contract

The map is generated from `ShellChromeProvider`; it does not duplicate manual screen lists. This keeps Top, left primary, left secondary, right context, footer and known CRUD resource links aligned with the runtime shell.

The page is intentionally complementary to `/interfacing/shell/diagnostics`:

- diagnostics answers whether required panels are present;
- navigation map answers what links each panel exposes.

## CRUD rule

Known component/entity links continue to use `CrudResourceExplorerProvider` and the generic CRUD bridge URL grammar. Planned resources may not resolve to owning persistence yet, but the visible URLs still follow the same CRUD bridge pattern.

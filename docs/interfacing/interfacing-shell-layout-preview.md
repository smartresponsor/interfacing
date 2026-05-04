# Interfacing shell layout preview

W15 adds a dedicated shell layout preview contract for the Interfacing component.

## Purpose

The page `/interfacing/shell/layout-preview` makes the common shell visible as a product surface, not only as a Twig implementation detail.

The JSON endpoint `/interfacing/shell/layout-preview.json` exposes the same contract for smoke checks and host-application verification.

## Canonical modes

- Four-column is the default: left primary, left secondary, body, right context.
- Three-column is allowed only when the right context panel is explicitly disabled.
- Top panel and Footer are always required.
- Both left panels and the body slot remain required in both modes.

## Drift guarded by this wave

- Pages must not silently drop Top or Footer.
- CRUD/application/dashboard pages must remain reachable through shared shell navigation.
- Compact pages must not redefine an unrelated layout system.

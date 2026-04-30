# Interfacing shell composition slots

Interfacing owns shell rendering, density, panel placement, primary navigation, section navigation, and footer rendering.

Component and bridge layers may contribute entries, but they should not render shell chrome themselves.

## Canonical shell slots

- `shell.topbar.left`
- `shell.topbar.right`
- `shell.nav.primary`
- `shell.nav.section`
- `shell.content.header`
- `shell.content.body`
- `shell.content.aside`
- `shell.footer.primary`
- `shell.footer.secondary`

## Current intent

- High-density platform shell
- Placeholder-ready legal/help/footer links
- Messaging/order/billing/catalog links visible early, even before all bridges are complete
- Bridges contribute navigation later; Interfacing renders placement and discipline

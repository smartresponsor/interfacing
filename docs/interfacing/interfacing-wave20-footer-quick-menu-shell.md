# Interfacing wave20 — Footer and quick menu commerce shell

This wave is rebased on the uploaded current slice `InterfacingSan1.zip`. The previous wave20 archive was not assumed to be applied.

## Intent

The host shell footer is treated as a system-wide navigation surface for the e-commerce application, not as a small legal/help area. Every page that renders through the Interfacing base shell should expose broad application indexes, component index links, locale selection, system links and support/policy links.

The body and side panels remain available for product-oriented commerce screens. The footer carries low-frequency cross-application navigation, while the top quick menu carries high-frequency account and commerce shortcuts.

## Footer taxonomy

The canonical footer groups are:

- `Commerce core`
- `Commerce finance`
- `Customer account`
- `Application indexes`
- `System links`
- `Support & policy`

`ShellFooterProvider` also keeps a dedicated `Locale` group because it has request-aware locale-selector state.

## Quick menu taxonomy

The top dropdown publishes:

- `My account`
- `My commerce`
- `System shortcuts`

The menu is intentionally HTML/CSS-only through `<details>` so it works in the standalone Symfony slice without adding JavaScript ownership.

## Scope

- No public route names were changed.
- No CRUD bridge URLs were changed.
- The footer is available through `shell.footerGroup`.
- The quick menu is available through `shell.quickMenuGroup`.
- Existing `InterfacingRendererInterface` shell injection continues to make the footer available to all templates using the canonical base shell.

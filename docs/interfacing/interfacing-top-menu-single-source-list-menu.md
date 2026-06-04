# Interfacing top menu single-source list menu

This wave consolidates the application top menu into a single partial-rendered source and removes the dense button-strip behavior from the top panel.

## Canonical top panel

The application shell top panel keeps only three zones:

1. left brand/title link;
2. centered search form;
3. right-aligned compact menu icon.

The previous right-side row of direct shortcut buttons is intentionally removed from the top panel. Those actions belong inside the compact menu surface.

## Canonical menu shape

The menu is rendered by `templates/shell/partial/quick_menu.html.twig`.

The menu content is grouped by sections such as Account, Security, Billing, Products, and System. Inside every section, menu entries are native `ul/li` list items. The menu must not use a button-grid visual treatment for ordinary navigation.

POST-only actions such as switch-account and sign-out may remain HTML forms for transport correctness, but their controls are visually styled as list rows, not as boxed buttons.

## Session action placement

`Sign out` is reserved for the final Session section at the bottom of the menu. If an upstream quick menu group also contains `quick.sign-out`, the partial skips that item in its original group and renders the canonical final sign-out row instead.

## Non-goals

This wave does not change authentication/session behavior. It only defines the Interfacing shell presentation contract for the top panel and compact menu.


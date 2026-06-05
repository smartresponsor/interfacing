# Interfacing welcome/access footer and body audit

## Scope

This note covers the Interfacing-owned public access shell used by Sign-in, Sign-up,
and Sign-out pages.

## Finding

The first footer-only shell used a two-column welcome composition: a left dark hero
panel and a right form panel. That shape was acceptable as a first visual marker,
but it conflicts with the Accessing/Bridging chain because Accessing already
supplies the page title, explanatory copy, form, and action links.

When Bridging renders Accessing content inside the Interfacing access shell, the
result appears as a duplicated sign-in surface: a shell-level hero panel plus an
inner Accessing entry/form panel.

## Decision

The public access shell remains footer-only, but the body is now a compact
single-card surface:

- no top panel;
- no left application panel;
- no right context panel;
- no two-column hero/form split;
- brand marker above the card;
- one centered body card owned by the Accessing/Bridging payload.

The footer remains Interfacing-owned and is rendered as native `ul`/`li` groups.
Lists are intentionally vertical, unnumbered lists instead of wrapped horizontal
link rows.

## Template changed

- `templates/access/base.html.twig`

## Boundary

Interfacing owns the visual shell, card styling, native footer list styling, and
basic form-control styling needed by upstream Symfony forms.

Accessing/Bridging owns the actual page payload: form fields, action links,
second-factor copy, recovery copy, and security behavior.


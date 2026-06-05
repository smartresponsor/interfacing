# Interfacing public account template footer and body audit

## Scope

This note covers reusable Interfacing visual templates that an owning account/security component may render for sign-in, sign-up, recovery, and sign-out-adjacent pages.

## Finding

The first footer-only shell used a two-column welcome composition: a left dark hero panel and a right form panel. That shape was acceptable as a first visual marker, but it conflicts with the owning account/security payload when that payload already supplies the page title, explanatory copy, form, and action links.

When upstream account content is rendered inside the Interfacing public account template, the result must not appear as a duplicated sign-in surface.

## Decision

The public account template remains footer-only, but the body is now a compact single-card surface:

- no top panel;
- no left application panel;
- no right context panel;
- no two-column hero/form split;
- brand marker above the card;
- one centered body card reserved for the owning component payload.

The footer remains Interfacing-owned and is rendered as native `ul`/`li` groups. Lists are intentionally vertical, unnumbered lists instead of wrapped horizontal link rows.

## Template changed

- `templates/access/base.html.twig`

## Boundary

Interfacing owns reusable visual primitives, card styling, native footer list styling, and basic form-control styling needed by upstream Symfony forms.

The owning account/security component owns the actual page payload: form fields, action links, second-factor copy, recovery copy, route processing, credentials, sessions, logout, and security behavior.

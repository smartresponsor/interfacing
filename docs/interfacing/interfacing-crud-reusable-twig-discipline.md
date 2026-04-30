# Interfacing reusable CRUD Twig discipline

The first CRUD workbench screen was intentionally not left as a one-off `order summary` mock.

This wave extracts a reusable Twig discipline for host-facing CRUD body rendering:

- `interfacing/crud/partial/page_head.html.twig`
- `interfacing/crud/partial/workbench_panel.html.twig`
- `interfacing/crud/partial/sidebar_card.html.twig`

## Canonical intent

These partials are not final business screens by themselves.
They define the stable middle-body composition pattern for CRUD/workbench surfaces:

- page header
- action toolbar
- main workbench panel
- sidebar cards
- form discipline placement
- data-heavy center area

## Current adopters

At this stage the discipline is proven in two screens:

- `interfacing/order/summary`
- `interfacing/billing/meter`

Both now render with the same workbench composition and the same Ant Design / ProComponents-oriented center-body semantics.

## Why this matters

This keeps Interfacing from drifting into screen-by-screen Twig duplication.
Future ecosystem components can plug their own metadata, rows, actions, and form fields into the same body contract instead of inventing a new page composition every time.

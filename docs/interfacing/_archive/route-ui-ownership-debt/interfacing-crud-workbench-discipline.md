# Interfacing CRUD workbench discipline

## Decision

For the canonical host-facing CRUD body surface, Interfacing currently treats **Ant Design + ProComponents** as the primary discipline.

PrimeReact stays reserved for richer facade and special widget zones, not for the default data-heavy command surface.

## Why

The host application already exposes a universal CRUD-command routing layer. That means the middle body area in an HTML page must be optimized for:

- filters,
- forms,
- primary and destructive commands,
- data tables,
- record selection,
- edit/detail workbench behavior,
- next-step progression.

This aligns more naturally with an Ant Design / ProComponents workbench posture than with a facade-first widget posture.

## First vertical slice

The first visual vertical slice is the order summary workbench screen:

- route: `/interfacing/order/summary`
- provider discipline: Ant Design / ProComponents inspired body semantics
- includes:
  - page header and toolbar,
  - filter strip,
  - table/listing,
  - row-level CRUD commands,
  - right-side detail/form panel,
  - next-step button.

## Scope note

This wave is intentionally limited to Interfacing itself. It does not prescribe host-side Composer wiring or host-side route assembly.

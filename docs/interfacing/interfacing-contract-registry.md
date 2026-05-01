# Interfacing contract registry

The Contract Registry screen at `/interfacing/contracts` formalizes the boundary between Interfacing and the owning Smart Responsor components.

Interfacing owns shell, navigation, route grammar, table frames, form frames, operation affordances and status presentation. Owning components own records, fixtures, identifiers, field schema, validation, persistence handlers, authorization and audit evidence.

The screen derives its rows from the evidence registry and translates evidence grades into contract grades:

- `missing`: the component is known or planned, but owner contracts are not published.
- `draft`: the component has a canonical resource shape, but runtime proof is incomplete.
- `formalized`: the component has connected screen, data, operation, policy and evidence contracts.

This page is intentionally not a data fixture source. It should never introduce business rows inside Interfacing.

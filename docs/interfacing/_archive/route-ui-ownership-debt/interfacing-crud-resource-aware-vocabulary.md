= Interfacing CRUD resource-aware vocabulary

The CRUD renderer now varies filter labels, option wording, placeholders, table column labels, and form/selection facts by resourcePath.

== Current resource-specific vocabulary

* sales/order
** Workflow state
** Submitted from / Submitted to
** Request ref / Gross total / Customer email

* billing/meter
** Reading state
** Window from / Window to
** Meter ref / Reading window / Billed amount

This keeps the host-aligned CRUD renderer entity-agnostic at the route-contract level while still making the central workbench feel semantically aligned to the resource being rendered.

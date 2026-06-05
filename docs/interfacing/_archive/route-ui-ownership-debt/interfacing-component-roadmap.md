# Interfacing Component Roadmap

The component roadmap screen exposes the full known Smart Responsor component surface without embedding business demo data in Interfacing.

## Route

`/interfacing/components`

## Purpose

- list all known commerce/platform components, including planned components that are not connected in the host yet;
- show required e-commerce screens per component;
- show canonical CRUD resource names and route entry points;
- preserve the boundary that component fixtures/providers own business rows.

## Status meanings

- `connected` — a host-visible screen or route is already connected.
- `canonical` — route grammar/resource naming is known and should be visible for navigation readiness.
- `planned` — component is known to the ecosystem but may not be installed or connected in the current host application.

## Boundary

Interfacing renders chrome, menus, CRUD affordances, status legends and route discipline. It must not store product, order, invoice, message, vendor or tax demo rows.

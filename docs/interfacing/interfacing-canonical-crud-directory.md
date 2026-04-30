# Interfacing Canonical CRUD Directory

Interfacing now treats the CRUD Explorer as a permanent shell-native directory for generic CRUD resources across the Smart Responsor ecosystem.

## Law

- Generic CRUD links must follow the Cruding entity/operation grammar.
- Interfacing may expose canonical CRUD links even before a component is fully connected to the host.
- A 404 from a canonical CRUD link is still useful because it reveals the exact path the component is expected to honour later.
- Component-specific custom pages remain outside this directory and continue to live in their own bridges.

## Grammar

- `/{resourcePath}/`
- `/{resourcePath}/new/`
- `/{resourcePath}/{id|slug}`
- `/{resourcePath}/edit/{id|slug}`
- `/{resourcePath}/delete/{id|slug}`

## Scope

The directory is intentionally broad. It lists:

- currently connected resources
- known ecosystem resources not yet connected

This gives operators a single place to walk real canonical CRUD paths across the platform.

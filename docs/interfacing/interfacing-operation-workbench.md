# Interfacing operation workbench

This wave adds a shell-native operation workbench at `/interfacing/operations`.

The page is intentionally generated from the canonical CRUD registry instead of Interfacing-owned business demo data. Each resource is rendered as one command card with these links:

- index
- new
- show sample
- edit sample
- delete sample

`show`, `edit`, and `delete` use a sample identifier only to expose the canonical route grammar before the owning component provides real records. Real rows, fixtures, identifiers, and delete semantics remain the responsibility of the owning Smart Responsor component.

The workbench is a fast EasyAdmin-style compensation surface: it gives the operator one predictable place to open all known commerce/admin resources while preserving the boundary that Interfacing owns shell, navigation, route grammar, and rendering contracts only.

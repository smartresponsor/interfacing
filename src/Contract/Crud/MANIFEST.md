# Manifest

## Wave 15 — Neutral CRUD preview DTOs

- `InterfaceCrudPreviewPage.php`
- `InterfaceCrudPreviewRow.php`

These DTOs are the generic preview shape for the CRUD workbench handoff. They intentionally avoid order, billing, or owning-component vocabulary.


## Wave 16 — CRUD resource descriptors

- `InterfaceCrudResourceDescriptorInterface.php`
- `InterfaceCrudResourceDescriptor.php`

These descriptors are the canonical, URL-free metadata objects published by CRUD resource contributions. The provider layer turns them into view link sets after route generation and fallback materialization.

## Wave 17 — CRUD operation grammar

- `InterfaceCrudOperationGrammarInterface.php`
- `InterfaceCrudOperationGrammar.php`

These objects describe canonical CRUD handoff operations, route names, route grammar, UI variants, and route parameters. New CRUD handoff code should consume the grammar provider rather than hardcoding `index/new/show/edit/delete` arrays.

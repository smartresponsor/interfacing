# Manifest

## Wave 15 — Neutral CRUD preview DTOs

- `CrudPreviewPage.php`
- `CrudPreviewRow.php`

These DTOs are the generic preview shape for the CRUD workbench bridge. They intentionally avoid order, billing, or owning-component vocabulary.


## Wave 16 — CRUD resource descriptors

- `CrudResourceDescriptorInterface.php`
- `CrudResourceDescriptor.php`

These descriptors are the canonical, URL-free metadata objects published by CRUD resource contributions. The provider layer turns them into view link sets after route generation and fallback materialization.

## Wave 17 — CRUD operation grammar

- `CrudOperationGrammarInterface.php`
- `CrudOperationGrammar.php`

These objects describe canonical CRUD bridge operations, route names, route grammar, UI variants, and route parameters. New CRUD bridge code should consume the grammar provider rather than hardcoding `index/new/show/edit/delete` arrays.

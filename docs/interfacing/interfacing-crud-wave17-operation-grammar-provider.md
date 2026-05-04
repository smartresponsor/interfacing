# Interfacing CRUD wave17 — operation grammar provider

Wave17 moves the generic CRUD bridge operation grammar into a canonical provider contract.

## Canonical contracts

- `src/Contract/Crud/CrudOperationGrammarInterface.php`
- `src/Contract/Crud/CrudOperationGrammar.php`
- `src/ServiceInterface/Interfacing/Crud/CrudOperationGrammarProviderInterface.php`
- `src/Service/Interfacing/Crud/DefaultCrudOperationGrammarProvider.php`

## Responsibility split

The operation grammar provider owns the canonical CRUD bridge vocabulary:

- operation id: `index`, `new`, `show`, `edit`, `delete`
- route name: `app_crud_*`
- route grammar: `/{resourcePath}/...`
- UI variant metadata for launch surfaces
- route parameters for sample URLs

`CrudExplorerViewBuilder` consumes the provider for link payloads, operation launchpad payloads, route expectation payloads, and route grammar summaries.

`CrudResourceExplorerProvider` also consumes the provider for sample show/edit/delete route generation, so route-name knowledge is not duplicated in descriptor normalization.

## Compatibility notes

Existing public route names and URL shapes are unchanged. The provider only centralizes the vocabulary that was previously hardcoded in multiple service methods.

`Contract/View/CrudResourceLinkSet` still exposes compatibility methods such as `operationUrls()` and `operationPatterns()`. A later wave can move those operation arrays fully behind the grammar provider if the view contract needs to become URL-grammar neutral.

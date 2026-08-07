# Catalog interface

- Canonical renderer: `templates/catalog/index.html.twig`
- Contract: Cataloging provides the catalog contract and Interfacing renders it.
- The template consumes the contract `slots` payload and does not own catalog business rules.
- `top.search` renders marketplace search.
- `left.panel` renders catalog and breadcrumb navigation.
- `main.body` renders marketplace/category hero content and card sections.
- `right.panel` renders statistics and available actions.
- Catalog cards support `imageUrl`, `kind`, `title`, `summary`, `status`, `itemCount`, `tags`, and `href`.

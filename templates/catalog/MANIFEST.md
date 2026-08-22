# Catalog interface

- Canonical renderer: `templates/catalog/index.html.twig`.
- Cataloging owns catalog business semantics; Cruding owns generic CRUD routing and operations.
- Interfacing renders the neutral catalog view/workbench payload supplied by the host or owning component.
- The template consumes `view`, `locations`, and `meta`; workbench data may provide rows, columns, filters, actions, route context, and context-tree nodes.
- Interfacing does not discover sibling catalog state, invent business routes, own persistence, or define generic CRUD grammar.
- Response-format and fallback decisions remain outside this template boundary.

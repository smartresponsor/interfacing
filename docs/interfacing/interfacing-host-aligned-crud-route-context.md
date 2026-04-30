# Interfacing host-aligned CRUD route context

Interfacing now treats host CRUD routing semantics as the primary rendering input for the central workbench body.

Canonical route semantics:
- `resourcePath`
- `_crud_operation`
- `_crud_surface`
- `id|slug`

Route segment sequence expected by the renderer:
- `{resourcePath}/` → index
- `{resourcePath}/new/` → new
- `{resourcePath}/edit/{id|slug}` → edit
- `{resourcePath}/delete/{id|slug}` → delete
- `{resourcePath}/{id|slug}` → show

Implication for Interfacing:
- renderer logic must stay resource-agnostic;
- the same center-body discipline can serve category, vendor, user, product, billing meter, order summary, and other resources;
- action generation and screen mode derive from route semantics rather than entity-specific Twig trees.

Current internal fallback resource paths used by demo screens:
- order summary → `sales/order`
- billing meter → `billing/meter`

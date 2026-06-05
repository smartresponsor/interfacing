= Interfacing CRUD identifier-aware routing discipline

Interfacing now treats CRUD route semantics as a combination of:

- resource path
- operation
- surface
- identifier field
- identifier value

The renderer no longer presents identifier values as anonymous tokens.
It now distinguishes between:

- internal operator-facing id addressing
- SEO/public slug addressing
- collection scope without identifier

This matters because the host CRUD layer already differentiates `/edit/{id}` and `/edit/{slug}` semantics.
Interfacing should therefore reflect not only the identifier value, but the identifier kind and its intended usage posture.

Additionally, resource paths are normalized into:

- resource labels
- breadcrumb items

This keeps the center-body workbench aligned with host routing semantics rather than with screen-specific hardcoded titles.

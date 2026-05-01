# Interfacing CRUD Corrective Patch

This patch stabilizes the current Interfacing slice around shell-visible CRUD discovery.

## Decisions

- Interfacing owns shell chrome, navigation, route grammar, rendering contracts and empty states.
- Business demo rows must not be owned by Interfacing runtime providers.
- Component-specific CRUD contributions outrank generic ecosystem placeholders.
- Planned resources stay visible in the CRUD Explorer so the operator can see the future Smart Responsor e-commerce surface before every host route is connected.

## CRUD resource statuses

- `connected`: concrete host route is known by the contribution.
- `canonical`: resource is known and follows canonical Cruding grammar.
- `planned`: ecosystem-forward placeholder. It may 404 until the host/component wires the resource path.

## Canonical grammar

```text
/{resourcePath}/
/{resourcePath}/new/
/{resourcePath}/{id}
/{resourcePath}/edit/{id}
/{resourcePath}/delete/{id}
```

The Explorer materializes show/edit/delete links with a sample identifier so the operator can quickly inspect the actual address-bar shape.

## Demo-data boundary

Demo providers are excluded from runtime provider discovery in the service configuration. Existing demo classes are kept in the repository for non-destructive cleanup, but runtime screen catalogs should not depend on them.

Messaging layout screens now render empty contract states. Real rows must come from Messaging fixtures, API providers, or live component bridges.

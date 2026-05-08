# Interfacing Admin Body UI Provider Canon

This document is the operator/Codex-facing UI provider canon for Interfacing and consumer repositories.

## Canonical provider ownership

The Interfacing admin body is **not a Bootstrap**, handmade Twig, or composer-inferred design system.

| Zone | Provider | Source ecosystem | Role |
| --- | --- | --- | --- |
| Admin/business workbench body | Ant Design + ProComponents | NPM/frontend | Primary renderer |
| Rich facade, inspectors, overlays, special widgets | PrimeReact | NPM/frontend | Secondary renderer |
| Shell slot, mount attributes, schema payload, provider scripts | Twig/Symfony | Composer/PHP | Contract wiring only |

Composer dependencies such as Symfony Twig, Symfony Form, and Objecting are PHP/runtime infrastructure. They must not be interpreted as Bootstrap or as the final visual provider for CRUD/admin body screens.

## Strict rendering rule

The admin body rendering mode is `canonical-provider-required`.

Twig must not render a parallel CRUD/admin UI. It may publish only:

- the shared ecosystem shell inheritance;
- the central body mount element;
- data attributes and JSON schema payload;
- provider script wiring for the canonical frontend providers.

## Non-negotiable rules for Codex and local agents

- Do not introduce Bootstrap as a design provider unless an explicit future canon adds it.
- Do not add Bootstrap class systems such as `btn btn-*`, `container-fluid`, `row`, or `col-*` to admin body templates.
- Do not hardcode a new admin UI design system in Twig/CSS.
- Do not add inline admin body CSS to Twig templates.
- Real CRUD/admin workbench rendering belongs to Ant Design ProComponents through the Interfacing admin body schema/runtime contract.
- PrimeReact is available for secondary rich-facade surfaces and must not silently replace Ant Design ProComponents for table/form CRUD workbenches.

## Frontend build surface

Install frontend dependencies and build the canonical provider bundle:

```bash
npm install
npm run ui:build
```

The Vite workspace is under `.interfacing/workspace/` and publishes the canonical provider bundle expected by the Twig mount:

```text
public/interfacing/admin-body/canonical-providers.js
```

## Local guard

Run the provider canon guard with:

```bash
php tools/interfacing/admin-body-ui-provider-canon-guard.php
```

The RC readiness gate also runs this guard.

## Frontend build line

The canonical provider workspace uses React 18 (`react` and `react-dom` at `^18.3.1`) for the Ant Design ProComponents and PrimeReact provider surface. Build hygiene is guarded by `tools/interfacing/admin-body-frontend-build-guard.php`.

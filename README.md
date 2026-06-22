# Interfacing

Interfacing is a Symfony runtime application and bundle for shared interface templates.

From the outside, Interfacing is passive: it does not query sibling components,
discover external business state, or own upstream data lookup. Inside its own
runtime, it may expose business routes and business controllers when those routes
belong to the interface experience itself.

For local development, this repository may keep a small standalone runtime only
to debug Composer, Symfony container wiring, Twig registration, and package
assets. That runtime is not the product boundary.

## Responsibility

Interfacing owns:

- reusable Twig templates under `templates/`;
- the `@Interfacing` Twig namespace;
- passive shell, layout, slot, partial, and provider template structure;
- static public assets required by those templates;
- minimal bundle/container registration needed for template use;
- Interfacing-owned business routes and controllers when they express real interface behavior;
- EasyAdmin admin runtime, including its required CRUD controllers;
- local debug commands and QA scripts that validate this package.

Interfacing does not own:

- generic CRUD route grammar or generic CRUD execution outside EasyAdmin;
- generic CRUD controllers outside EasyAdmin;
- runtime discovery of external components;
- persistence, repository access, or business queries;
- legacy compatibility wrappers.

## Runtime model

```text
production host
  -> installs InterfacingBundle
  -> receives @Interfacing Twig namespace
  -> chooses and renders templates from host/runtime code

local development
  -> uses this repository as a sibling package
  -> may boot a debug kernel
  -> validates Composer, Symfony container, Twig, assets, and QA gates
```

## Template model

The most valuable part of this repository is the `templates/` tree. Template
folders describe passive template areas and view fragments. They are not proof
of business ownership.

Use neutral template language such as `template`, `view`, `screen`, `slot`,
`partial`, `layout`, and `fragment` for new code and documentation. Avoid using
`Surface` as a folder, class, route, runtime token, or compatibility wrapper.

## Development checks

Available Composer scripts include:


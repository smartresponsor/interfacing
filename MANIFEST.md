# Interfacing Manifest

Interfacing is a Symfony runtime application and bundle for shared interface templates.

From the outside, Interfacing is passive: it does not query sibling components,
discover external business state, or own upstream data lookup.

Current responsibility:
- own the reusable `templates/` tree;
- expose the `@Interfacing` Twig namespace;
- ship passive shell, layout, slot, partial, provider, and view fragments;
- ship static assets needed by those templates;
- own Interfacing business routes and controllers when they express real interface behavior;
- own EasyAdmin admin runtime, including the CRUD controllers EasyAdmin requires;
- keep a standalone local runtime only for Composer, Symfony container, Twig, asset, and QA debugging.

Non-responsibility:
- no CRUD lifecycle, route grammar, or operation dispatch;
- no component discovery or bridge runtime;
- no persistence, repository access, or business data lookup;
- no legacy compatibility wrappers.

Vocabulary canon:
- prefer `template`, `view`, `screen`, `slot`, `partial`, `layout`, and `fragment`;
- do not introduce `Surface` as a folder, class, route, runtime token, or compatibility wrapper;
- CSS design tokens may keep provider-library names only when they are vendor-facing style tokens, not PHP/runtime concepts.

Production model:
- host application installs `InterfacingBundle`;
- host application owns routing and rendering decisions;
- Interfacing provides templates and bundle registration only.

Local development model:
- this repository can run as a sibling package;
- local runtime exists to validate Composer, Symfony container, Twig namespace, assets, and QA gates;
- local debug runtime must not become product ownership.

Reading order:
1. `README.md`
2. `composer.json`
3. `AGENTS.md`
4. `config/routes.yaml`
5. `src/InterfacingBundle.php`
6. `src/DependencyInjection/InterfacingExtension.php`

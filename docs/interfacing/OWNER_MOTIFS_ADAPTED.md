# Owner Motifs Adapted — Interfacing

This file adapts owner-level Symfony and product-growth motives to the Interfacing repository.

## Structural canon
- Keep one root code tree only: `App\ => src/`.
- Do not introduce alternative root namespaces.
- Do not create new `src/Domain` or `src/Infra` feature trees.
- Prefer Symfony-oriented trees with clear responsibility names.
- Keep service contracts mirrored in `src/ServiceInterface/*` symmetrically to `src/Service/*`.
- Avoid repository/component-name wrapper folders near the root code tree.

## Interfacing-specific product mission
- Build Interfacing as the ecosystem interface application.
- It owns public surfaces, authenticated workspace surfaces, and privileged operator/admin surfaces.
- It owns shell, layouts, widgets, screen composition, live interaction surfaces, management UI, and governed upstream UI delivery.
- It should not split into unrelated front/admin UI domains.

## Engineering direction
- Keep controllers thin.
- Keep repositories persistence-focused only.
- Use DTO where data crosses controller, CLI, form, live component, or application boundaries.
- Use ValueObjects for real business meaning where they help.
- Use Symfony Validator at the right layer.
- Use Twig + Bootstrap for clean operational UI inside the Symfony runtime.
- Use UX Live Components where they materially improve interaction.
- Use logs and reports as repair inputs.

## Operational direction
- Maintain a broad, useful Symfony Console layer.
- Keep fixtures meaningful and runnable.
- Strengthen layered tests where they cover real flows.
- Keep local quality gates practical: lint, style, static analysis, tests, browser automation where justified.
- Keep browser automation compatible with local Symfony runtime and predictable fixtures.

## UI platform direction
- PrimeReact enriches facade and shell zones.
- Ant Design + ProComponents strengthen entity/workbench/data-heavy zones.
- Consumers do not import raw vendor pieces arbitrarily; they consume governed wrappers and contracts through the managed `.interfacing/` mirror.

## Change strategy
- Inspect the repository first.
- Prefer cumulative, grounded progress.
- When renaming or moving, fix all references.
- Keep the best working code during conflicts.
- Avoid decorative complexity and format churn.

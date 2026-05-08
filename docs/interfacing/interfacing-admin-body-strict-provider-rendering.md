# Interfacing admin body strict provider rendering

Wave 33 removes the provider-less admin body path. Interfacing now treats the central CRUD/admin body as provider-required.

## Canonical chain

```text
single ecosystem shell
  -> central admin body mount
      -> schema payload
      -> provider registry
      -> canonical provider bundle from .interfacing/workspace
      -> Ant Design ProComponents primary renderer
      -> PrimeReact secondary rich-facade provider
      -> runtime hydration
```

Twig does not render an alternate table, card view, form, detail page, or admin toolbar. Those surfaces belong to Ant Design ProComponents and PrimeReact according to their assigned roles.

## Removed drift

The strict provider rendering wave removes these sources of confusion:

- inline admin body CSS in `template/interfacing/crud/workbench_base.html.twig`;
- native Twig CRUD table/card/form blocks inside `template/interfacing/crud/screen.html.twig`;
- provider-less admin body regions inside `template/interfacing/admin/body/mount.html.twig`;
- smoke expectations that treat a missing primary provider as acceptable;
- documentation that tells Codex/local agents to continue handmade Twig CSS.

## Required commands

```bash
npm install
npm run ui:build
php tools/interfacing/admin-body-rc-readiness.php
```

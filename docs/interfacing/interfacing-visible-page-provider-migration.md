# Interfacing visible page provider migration

Visible Interfacing pages are now provider-owned surfaces.

Twig pages must not render bespoke admin tables, bespoke forms, inline CSS,
Bootstrap-like layouts, or provider-less fallback UI as their primary body.
Instead, visible pages extend:

```twig
{% extends 'interfacing/admin/body/provider_page.html.twig' %}
```

The provider page enters the shared Interfacing shell and mounts the canonical
admin body provider chain:

- Ant Design ProComponents as the primary admin/workbench renderer.
- PrimeReact as the secondary rich-facade provider.

The migration covers page-like Interfacing templates under `template/component`,
`template/interfacing/page`, `template/interfacing/screen`, `doctor`, `billing`,
`category`, `order`, selected `widget/*` demo surfaces, and CRUD mode templates.

Guard:

```bash
php tools/interfacing/admin-body-visible-page-provider-migration-guard.php
```

This guard fails if visible pages reintroduce `<table>`, `<form>`, `<style>`,
Bootstrap-like classes, or fail to extend the provider page template.

# Interfacing admin body schema contract

Interfacing owns the ecosystem shell, the central body slot, and a conservative Twig provider-less UI. The hydrated admin/business body is provider-owned: Ant Design + ProComponents is the canonical workbench provider, and PrimeReact remains the secondary rich facade provider.

## Purpose

The admin body mount now publishes a machine-readable JSON schema next to the provider-less markup. This keeps the future frontend layer from scraping CSS classes or inventing ad hoc data attributes.

The schema is emitted by:

```twig
interfacing/admin/body/schema.html.twig
```

and included by:

```twig
interfacing/admin/body/mount.html.twig
```

## Canonical contract

The JSON script uses:

```html
<script type="application/json" data-interfacing-admin-body-schema="true">...</script>
```

The payload includes stable top-level sections:

- `schema`
- `version`
- `providers`
- `resource`
- `operation`
- `surface`
- `view`
- `locale`
- `toolbar`
- `table`
- `cards`
- `form`
- `actions`
- `provider-less path`

These sections map directly to the Ant Design ProComponents body discipline: PageContainer, ProTable, ProForm, segmented view switcher, content-locale selector, action column, and row/header actions.

## Provider boundary

Twig must not become the final UI framework. It provides:

- shell inheritance;
- body mount;
- JSON schema;
- no-JS/smoke provider-less path.

The hydrated provider should own the rich implementation:

- `ProTable` for collection/table browsing;
- card mode as a secondary view;
- `ProForm` for create/edit flows;
- provider-native toolbar controls;
- provider-native action column.

## Forbidden drift

The schema/mount layer must not reintroduce:

- Cruding-specific adapters;
- HostApp copy/install operations;
- `templates/bundles/CrudingBundle` override distribution;
- native Twig as the canonical rich admin UI.

Use the guard:

```bash
php tools/interfacing/admin-body-mount-contract-guard.php
```

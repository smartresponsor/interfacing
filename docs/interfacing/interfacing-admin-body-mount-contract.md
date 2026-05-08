# Interfacing admin body mount contract

Interfacing owns the ecosystem shell and the central body slot. The CRUD/admin body is not a separate Cruding adapter and it is not distributed by copying bundle overrides into a host app.

The canonical model is:

```text
single ecosystem shell
  -> central body slot
      -> admin body mount contract
          -> Ant Design + ProComponents interactive workbench
          -> Twig provider-less UI for smoke/no-JS/server-provider-required rendering
```

## Provider discipline

- `antd-pro` is the canonical provider for administrative/business workbench screens.
- `primereact` remains the secondary provider for rich facade widgets, special panels, previews, and interactive surfaces.
- Twig must not become a competing design system. Twig declares shell inheritance, mount attributes, and conservative provider-less markup.

## Required body affordances

Every generic CRUD/admin body surface must expose:

- a visible table-first region;
- an optional card/grid region;
- a content-locale switcher in the body toolbar;
- a table/card view-mode switcher;
- row/card actions such as view, edit, and delete;
- a form region for new/edit surfaces;
- data attributes that allow a provider-native Ant Design ProComponents workbench to hydrate the body.

## Canonical Twig mount

The canonical mount template is:

```text
template/interfacing/admin/body/mount.html.twig
```

It exposes these markers:

```text
data-interfacing-admin-body-mount="true"
data-admin-body-contract="ant-design-procomponents"
data-content-locale-switcher="true"
data-view-mode-switcher="true"
data-admin-table-region="true"
data-admin-card-region="true"
data-admin-form-region="true"
data-admin-body-provider-less path="twig"
```

## What this deliberately avoids

This wave deliberately avoids:

- Cruding-specific shell adapters;
- host-app copy/install flows;
- Symfony bundle override packs as the primary integration model;
- handmade Twig as the final admin UI provider.

Connected applications should inherit the same ecosystem base and render into the same central body slot. The provider-native workbench then hydrates the body mount according to the Ant Design ProComponents discipline.

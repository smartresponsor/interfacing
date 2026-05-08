# Interfacing admin body toolbar policy contract

Wave 15 canonizes the toolbar discipline for central admin/body workbench screens.
The shell remains a single ecosystem frame. CRUD/admin content still enters the
central body mount and is intended to hydrate through Ant Design ProComponents.

## Canonical toolbar controls

The toolbar policy is exposed as `toolbarPolicy` in the admin body JSON schema.
It declares these controls:

- `search` for the ProTable toolbar search surface.
- `filters` for the ProTable search/filter form surface.
- `content-locale` for localized business content selection.
- `view-mode` for the table/card segmented control.
- `bulk-actions`, currently disabled until a row-selection contract is added.

## Provider targets

The schema maps toolbar controls to provider targets:

- `ProTable.toolbar.search`
- `ProTable.search`
- `PageContainer.extra.contentLocale`
- `PageContainer.extra.viewMode`
- `ProTable.tableAlertOption`

PrimeReact remains a secondary rich-facade provider and must not replace Ant
Design ProComponents for the CRUD/admin body toolbar.

## Provider-less path rule

Twig provider-less UI may render conservative controls for smoke and no-JS mode, but the
contract is provider-oriented. The provider-less path is not a separate design system.

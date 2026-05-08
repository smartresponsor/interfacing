# Interfacing admin body responsive layout policy contract

This contract fixes the responsive behavior of the central admin/body workbench without changing the global ecosystem shell.

## Ownership

- `ecosystem-shell` owns the outer frame, menus, panels, quick menu, and footer.
- `ant-design-procomponents` owns the central admin/body responsive behavior.
- Twig keeps only a provider-less rendering path and policy markers.

## Required behavior

The provider must support these breakpoints:

- `desktop`: full workbench, inline toolbar, expanded filters, default `middle` density.
- `tablet`: condensed workbench, wrapped toolbar, collapsible filters.
- `mobile`: single-column workbench, stacked toolbar, drawer/collapsed filters, compact table density.

Tables remain table-first. On narrow screens they use `horizontal-scroll-on-narrow` and preserve the action column. Cards are allowed as a secondary narrow-screen view, but they do not replace the table contract.

## Provider targets

- `PageContainer`
- `ProTable`
- `ProTable.scroll`
- `ProTable.options`
- `ProTable.search`
- `ProForm.layout`
- `ProCard.grid`
- `Descriptions.column`

## Runtime validation

The runtime validates `responsiveLayoutPolicy` before provider hydration. If the policy is missing or incomplete it sets:

```text
data-admin-body-hydration="responsive-layout-policy-error"
```

and dispatches:

```text
interfacing:admin-body:responsive-layout-policy-error
interfacing:admin-body:hydration-failed
```

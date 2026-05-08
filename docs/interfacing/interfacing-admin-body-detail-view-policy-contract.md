# Interfacing admin body detail-view policy contract

## Purpose

`show` and read-only resource screens must use the same central admin body discipline as list and form screens. They should not become custom dashboard pages inside the body column.

The canonical mapping is:

- `PageContainer` for title, back/edit/delete actions, and page-level context.
- `Descriptions` for the primary read-only field layout.
- `ProCard.metadata` for technical and lifecycle metadata.
- `ProCard.relations` for linked records or relation summaries.
- `Modal.confirm` for destructive delete confirmation.

Twig keeps only a provider-less rendering path region. It does not become the final design system.

## Contract

The machine-readable schema publishes `detailViewPolicy` with:

- `mode: show`;
- `readOnly: true`;
- sections: `general`, `metadata`, `relations`;
- actions: `back-to-list`, `edit`, `delete`;
- destructive action protection for `delete`;
- provider targets for Ant Design ProComponents.

## Runtime behavior

The runtime validates `detailViewPolicy` before hydration. If the policy is missing or incomplete, it sets:

```text
data-admin-body-hydration="detail-view-policy-error"
```

and emits:

```text
interfacing:admin-body:detail-view-policy-error
```

The Twig provider-less UI remains visible in that case.

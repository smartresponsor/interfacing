# Interfacing Admin Body Operation Policy Contract

Interfacing uses a single ecosystem shell and a central admin body mount. The shell owns navigation, panels, quick menu, and footer. The admin body mount owns a machine-readable contract for hydrated workbench renderers.

This operation policy layer complements the resource schema:

- `resourceContract` describes columns, filters, form fields, and CRUD data shape.
- `operationPolicy` describes which operations and actions are allowed and how they must be rendered.

## Canonical provider discipline

Ant Design ProComponents remains the primary admin/workbench provider. It should map the operation policy to:

- `PageContainer.extra` for header actions.
- `ProTable.actionColumn` for row actions.
- `ProForm.submitter` for form submit/cancel actions.

PrimeReact remains a secondary rich-facade provider and must not replace the primary CRUD renderer.

## Required policy keys

The `operationPolicy` payload must include:

- `name`
- `version`
- `supportedOperations`
- `currentOperation`
- `headerActions`
- `rowActions`
- `destructiveActions`
- `confirmation`
- `providerTargets`

The runtime refuses hydration and keeps Twig provider-less UI visible when the operation policy is missing or incomplete.

## CRUD operations

The canonical supported operations are:

- `index`
- `show`
- `new`
- `edit`
- `delete`

The canonical UI actions are:

- `create`
- `view`
- `edit`
- `delete`

## Destructive actions

`delete` is always destructive and must use explicit confirmation:

- confirmation state: `confirmation-required`
- rendering pattern: `danger-action-with-confirmation`

The renderer must not expose delete as a silent direct link or plain unconfirmed button.

## Runtime behavior

`assets/interfacing/admin-body/runtime.js` validates `operationPolicy` before provider hydration. If the policy is invalid, it sets:

```text
data-admin-body-hydration="operation-policy-error"
```

and emits:

```text
interfacing:admin-body:operation-policy-error
```

The Twig provider-less UI remains visible in that state.

## Guard

Run:

```bash
php tools/interfacing/admin-body-mount-contract-guard.php
```

The guard verifies the PHP contract, Twig schema payload, runtime validation markers, and the required delete-confirmation policy.

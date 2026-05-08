# Interfacing Admin Body Form Lifecycle Policy Contract

Wave 19 adds the form lifecycle policy for the central admin body mount.

The policy keeps create/edit screens aligned with the Ant Design ProComponents workbench discipline without making Twig a standalone UI system.

## Canon

- `antd-pro` remains the primary admin/workbench renderer.
- `ProForm` owns create/edit form rendering.
- Submit behavior is server-driven.
- Dirty forms require a navigation-away confirmation.
- Validation feedback belongs to provider-native `ProForm.validation`.
- Save, save-and-continue, cancel, and reset are explicit actions.
- Twig provider-less UI remains modest and must not become the final form UI.

## Provider targets

- Form container: `ProForm`
- Submitter: `ProForm.submitter`
- Validation: `ProForm.validation`
- Dirty-state confirmation: `Modal.confirm`
- Success feedback: `message.success`
- Error feedback: `message.error`

## Runtime guard

The runtime validates `formLifecyclePolicy` before provider hydration. Missing or incomplete policy sets `data-admin-body-hydration="form-lifecycle-policy-error"` and emits `interfacing:admin-body:form-lifecycle-policy-error`.

# Interfacing admin body telemetry policy contract

Interfacing admin body screens publish a browser-side telemetry policy so the
Ant Design ProComponents renderer can emit stable UI events without inventing
ad hoc event names per resource.

This is not backend audit logging. Backend voters, controllers, and audit logs
remain authoritative for security and business events. The telemetry policy only
covers renderer/runtime observability: hydration state, missing providers, view
mode changes, content-locale changes, selection changes, CRUD action intent,
denied UI actions, and form lifecycle intent.

## Canon

- `antd-pro` remains the primary admin/workbench renderer.
- Browser telemetry mode is `browser-ui-events`.
- Backend audit owner remains `backend-audit-log`.
- Browser events must not include raw field values or sensitive payloads.
- Event details must include stable context keys: resource, operation, surface,
  provider, and hydration state.

## Events

Canonical browser events:

- `interfacing:admin-body:ready`
- `interfacing:admin-body:hydration-failed`
- `interfacing:admin-body:provider-required-error`
- `interfacing:admin-body:action-intent`
- `interfacing:admin-body:action-denied`
- `interfacing:admin-body:view-mode-changed`
- `interfacing:admin-body:content-locale-changed`
- `interfacing:admin-body:selection-changed`
- `interfacing:admin-body:form-dirty-state-changed`
- `interfacing:admin-body:form-submit-intent`

## Provider target

The policy is consumed by the future Ant Design ProComponents provider and by
runtime diagnostics. Twig remains a shell, mount, schema, and provider-less path layer.

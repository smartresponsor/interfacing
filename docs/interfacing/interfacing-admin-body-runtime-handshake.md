# Interfacing Admin Body Runtime Handshake

Interfacing owns the ecosystem shell, the central body mount, and a conservative Twig provider-less UI. The hydrated admin/workbench body is provider-owned.

## Canonical provider split

- `antd-pro` / Ant Design ProComponents owns CRUD and business workbench rendering: `PageContainer`, `ProTable`, `ProForm`, action columns, filters, and admin toolbar controls.
- `primereact` remains the secondary rich-facade provider for specialized interactive surfaces.
- Twig must not grow into a parallel admin design system.

## Runtime entrypoint

The Asset Mapper entrypoint is:

```text
assets/interfacing/admin-body/runtime.js
```

The Twig mount loads it as:

```twig
<script type="module" src="{{ asset('interfacing/admin-body/runtime.js') }}" data-interfacing-admin-body-runtime="true"></script>
```

## Browser contract

The runtime reads the adjacent JSON payload marked with:

```text
data-interfacing-admin-body-schema="true"
```

It then emits:

```text
interfacing:admin-body:ready
```

The future Ant Design Pro renderer registers itself through:

```text
window.InterfacingAdminBodyProviders['antd-pro'] = { mount(mount, schema) { ... } }
```

Until that provider is present, the Twig provider-less UI remains visible and the mount receives:

```text
data-admin-body-hydration="provider-missing"
```

## Non-goals

This runtime does not copy files into host applications, does not introduce a Cruding-specific adapter, and does not implement the final UI in native Twig.

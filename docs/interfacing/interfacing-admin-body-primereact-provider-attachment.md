# Interfacing admin body PrimeReact provider attachment

Interfacing keeps a two-provider UI discipline:

- **Ant Design + ProComponents** owns the canonical admin/business workbench body: table-first collection screens, ProTable, ProForm, action columns, filters, and content-locale controls.
- **PrimeReact** is a secondary rich-facade provider for specialized widgets, inspectors, overlays, and richer interactive surfaces that can complement the body without replacing the canonical CRUD/admin discipline.

This wave adds only the attachment point for PrimeReact:

```text
single ecosystem shell
  -> admin body mount
      -> provider registry
          -> Ant Design Pro primary provider attachment
          -> PrimeReact secondary/rich-facade provider attachment
          -> runtime hydration
          -> Twig provider-less UI until a real provider mounts
```

The PrimeReact file `assets/interfacing/admin-body/providers/primereact.js` intentionally does not implement a fake renderer. It looks for a real external provider on:

```text
window.InterfacingPrimeReactAdminBodyProvider
```

If that object exposes `mount(mount, schema)`, the attachment registers it under the `primereact` provider key through `window.InterfacingAdminBodyProviderRegistry.register(...)`.

If the external provider is absent, the attachment emits `interfacing:admin-body:primereact-provider-missing` and leaves the Twig provider-less UI untouched.

This keeps Twig as shell/slots/schema/provider-less path and keeps provider-specific rendering in the frontend provider layer.

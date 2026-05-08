# Interfacing admin body provider registry

Interfacing owns the shared ecosystem shell, the central admin body mount, the
machine-readable schema payload, and the browser-side provider registry. It does
not own a custom native-Twig admin UI and it does not special-case Cruding.

## Purpose

The registry is the stable handoff between the Symfony/Twig layer and the future
frontend renderer layer:

```text
single ecosystem shell
  -> admin body mount
      -> JSON schema
          -> provider registry
              -> Ant Design ProComponents renderer
              -> conservative Twig provider-less UI until mounted
```

## Canonical browser globals

- `window.InterfacingAdminBodyProviders` stores provider implementations keyed
  by provider name.
- `window.InterfacingAdminBodyProviderRegistry` exposes `register`, `has`, `get`,
  and `list`.

A concrete renderer registers itself like this:

```js
window.InterfacingAdminBodyProviderRegistry.register('antd-pro', {
  mount(mount, schema) {
    // Mount the Ant Design ProComponents workbench here.
  },
});
```

The runtime continues to keep Twig provider-less UI visible when no provider is
registered. This is intentional: provider-less path is for smoke/no-JS/provider-required rendering, not
for replacing Ant Design ProComponents as the admin/workbench discipline.

## Boundaries

- No HostApp copy surface.
- No Cruding-specific adapter.
- No fake Ant Design Pro renderer inside Twig.
- PrimeReact remains the secondary rich-facade provider, not the default CRUD
  table/form provider.

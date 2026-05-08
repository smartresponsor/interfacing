# Interfacing admin body provider selection policy

Interfacing owns the ecosystem shell, central admin body mount, machine-readable schema, browser provider registry, and Twig provider-less UI. It does not implement a native table/form design system in Twig and does not make PrimeReact the default CRUD renderer.

## Canonical provider roles

| Provider | Role | May render CRUD/admin body by default |
| --- | --- | --- |
| `antd-pro` | `admin-workbench` | Yes |
| `primereact` | `rich-facade` | No |

Ant Design ProComponents remains the primary renderer for administrative table/form workbench pages: PageContainer, ProTable, ProForm, action column, toolbar, view switcher, and content locale switcher.

PrimeReact remains a secondary provider for rich facade zones: inspectors, overlays, widgets, preview surfaces, and specialized interactions around the admin body. It must not silently replace the primary `antd-pro` renderer for normal CRUD/admin body hydration.

## Runtime policy

The admin body schema publishes a `providerPolicy` object:

- `primary.provider = antd-pro`
- `primary.role = admin-workbench`
- `primary.required = true`
- `secondary.provider = primereact`
- `secondary.role = rich-facade`
- `secondary.provider-less pathMode = forbidden-for-admin-body`
- `secondary.mayReplacePrimary = false`

The runtime reads that policy before hydration. For `surface = admin`, it rejects a non-`antd-pro` primary provider and emits `interfacing:admin-body:provider-policy-error`.

If `antd-pro` is missing, the runtime marks hydration as `provider-required-error`, emits `interfacing:admin-body:provider-required-error`, and keeps the Twig provider-less UI visible. It does not provider-less path to PrimeReact for the central CRUD/admin workbench body.

## Why this exists

The previous provider registry made both providers visible, which is useful, but it could be misread as "either provider may own CRUD body rendering." This policy closes that ambiguity:

```text
single ecosystem shell
  -> central admin body mount
      -> Ant Design ProComponents primary renderer
      -> PrimeReact secondary rich-facade attachment
      -> Twig provider-less UI if primary renderer is absent
```

This keeps visual discipline close to an administrative workbench while preserving PrimeReact for richer auxiliary surfaces.

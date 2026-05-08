# Interfacing admin body Ant Design Pro provider attachment

Interfacing owns the shell, central body mount, JSON schema payload, provider registry, and safe Twig provider-less UI. It does not implement the Ant Design ProComponents renderer inside Twig and does not fake a React renderer in this repository slice.

The Ant Design Pro admin provider attachment point is:

- PHP contract: `App\Interfacing\Contract\Ui\AdminBodyAntDesignProProviderContract`
- browser entrypoint: `interfacing/admin-body/providers/antd-pro.js`
- external provider global: `window.InterfacingAntDesignProAdminBodyProvider`
- registry provider key: `antd-pro`

The external renderer must expose:

```js
window.InterfacingAntDesignProAdminBodyProvider = {
  mount(mount, schema) {
    // Real Ant Design ProComponents renderer mounts PageContainer,
    // ProTable, ProForm, action column, locale switcher, and view switcher.
  }
}
```

The local adapter only registers that external renderer with `window.InterfacingAdminBodyProviderRegistry` when it exists. If the renderer is missing, the adapter emits `interfacing:admin-body:antd-pro-provider-missing` and leaves the Twig provider-less UI visible.

This keeps the architecture simple:

```text
single ecosystem shell
  -> central admin body mount
      -> schema payload
      -> provider registry
      -> Ant Design Pro provider attachment
      -> runtime hydration
      -> Twig provider-less UI when provider is absent
```

Forbidden directions:

- no Cruding-specific shell adapter;
- no HostApp copy/override mechanism as the primary integration model;
- no fake native-Twig admin design system;
- no fake AntD/React renderer inside the provider attachment.

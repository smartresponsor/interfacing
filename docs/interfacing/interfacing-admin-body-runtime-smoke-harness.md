# Interfacing admin body runtime smoke harness

The admin body runtime smoke harness verifies the browser-side contract without
mounting a real Ant Design ProComponents renderer and without building a custom
Twig UI system.

It exercises two required scenarios:

1. `provider-required-error` — the schema is valid, the provider registry is
   available, but no `antd-pro` provider is registered. The runtime must keep the
   Twig provider-less UI visible and set `data-admin-body-hydration="provider-required-error"`.
2. `primary-provider-ready` — a minimal provider object is registered through
   `InterfacingAdminBodyProviderRegistry.register('antd-pro', provider)`. The
   runtime must call `provider.mount(mount, schema)` and set
   `data-admin-body-hydration="ready"`.

Run it from the repository root:

```powershell
node tools/interfacing/admin-body-runtime-smoke.mjs
```

or through the PowerShell wrapper:

```powershell
powershell -ExecutionPolicy Bypass -File tools/interfacing/admin-body-runtime-smoke.ps1
```

The harness is intentionally provider-neutral. It validates the contract surface
that a future real Ant Design Pro renderer will consume: schema payload,
registry lookup, ready event, missing-provider event, and hydration state.

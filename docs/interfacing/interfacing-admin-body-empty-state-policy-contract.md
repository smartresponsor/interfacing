# Interfacing admin body empty-state policy contract

Interfacing admin body screens must not leave loading, empty, error, validation, or offline states as ad hoc Twig fragments. The single ecosystem shell still owns frame composition, while the central admin body exposes a machine-readable `emptyStatePolicy` for the Ant Design ProComponents renderer.

## Canon

- `antd-pro` remains the primary admin/workbench provider.
- Empty collection rendering maps to `ProTable.locale.emptyText`.
- Loading maps to `ProTable.loading`.
- API/load failures map to an Ant Design `Result.error` surface.
- Form validation maps to `ProForm.validation`.
- Offline/degraded status maps to `Alert.offline`.
- Twig provider-less UI remains conservative and visible until the primary provider mounts.

## Required schema key

```text
emptyStatePolicy
```

The policy must include `name`, `version`, `states`, `actions`, and `providerTargets`.

This wave intentionally does not implement a fake React renderer. It fixes the contract so a real provider can render predictable states without parsing provider-less markup or inventing component-local conventions.

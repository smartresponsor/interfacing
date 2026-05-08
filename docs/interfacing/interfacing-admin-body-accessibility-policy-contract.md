# Interfacing admin body accessibility policy contract

Wave 24 adds the admin body accessibility policy. The policy is not a separate visual system and does not replace Ant Design ProComponents. It gives the configured provider a stable accessibility and keyboard contract for the central body workbench.

## Contract

The schema publishes `accessibilityPolicy` with:

- `mode: provider-native-required`
- semantic landmarks for page, toolbar, table, form, and detail regions
- keyboard navigation requirements for toolbar, row actions, dialogs, and forms
- focus restoration requirements after actions and destructive confirmations
- aria-live announcement targets for hydration, empty states, and validation errors

## Rendering responsibility

Twig remains responsible for the ecosystem shell, mount point, and provider-less rendering path. Ant Design ProComponents remains responsible for the primary admin/workbench UI and should map the policy to provider-native accessibility primitives.

PrimeReact remains secondary/rich-facade only and must not replace the admin CRUD workbench provider.

## Guarded behavior

The runtime validates `accessibilityPolicy` before provider hydration. If it is missing or incomplete, hydration stops with:

- `data-admin-body-hydration="accessibility-policy-error"`
- `interfacing:admin-body:accessibility-policy-error`
- `interfacing:admin-body:hydration-failed`

This keeps inaccessible admin body screens from silently hydrating over the provider-less path.

# Interfacing admin body schema manifest contract

Wave 26 consolidates the admin body payload into a discoverable manifest. The central body contract still follows the same runtime model: Twig owns shell, mount, and provider-less path; Ant Design ProComponents owns the primary admin workbench renderer; PrimeReact remains secondary rich-facade surface only.

## Purpose

The admin body schema now carries `schemaManifest` as a table of contents for the hydrated renderer and static guards. This avoids a drift-prone payload where every policy exists independently without a versioned index.

## Required payload sections

The manifest marks these policy sections as required:

- `providerPolicy`
- `resourceContract`
- `operationPolicy`
- `toolbarPolicy`
- `rowSelectionPolicy`
- `tableInteractionPolicy`
- `emptyStatePolicy`
- `formLifecyclePolicy`
- `detailViewPolicy`
- `navigationPolicy`
- `authorizationPolicy`
- `telemetryPolicy`
- `accessibilityPolicy`
- `responsiveLayoutPolicy`

## Runtime behavior

`runtime.js` validates `schemaManifest` before validating individual policy sections. If the manifest is absent or incomplete, hydration stops with:

- `data-admin-body-hydration="schema-manifest-error"`
- `interfacing:admin-body:schema-manifest-error`

The Twig provider-less UI remains visible until the primary provider successfully mounts.

# Interfacing Route / Controller Boundary — Wave 9

Wave 9 closes the main route-source drift without decomposing controller internals yet.

## Canonical route ownership

Interfacing-owned controller routes are attribute-owned and imported through:

```text
config/routes/interfacing_attributes.yaml
```

The import file is intentionally ordered. Specific controllers are imported first, while `InterfacingController` is imported last because it owns broad workspace routes such as `/interfacing/{id}`.

## YAML route ownership

YAML route files remain valid for bridge routes and scoped layout routes only.

`config/routes/interfacing.yaml` is now a legacy anchor and must not redeclare attribute-owned routes.

`config/routes/interfacing_layout.yaml` no longer owns `/interfacing` or `/interfacing/{slug}`. Layout routes are scoped under:

```text
/interfacing/layout
/interfacing/layout/{slug}
```

This prevents collision with the workspace index and broad workspace screen route.

## Screen route vocabulary

Two historically similar screen routes now have different responsibilities:

```text
/interfacing/catalog/screen/{screenId}
```

Uses `ScreenController` and the UI screen-spec catalog.

```text
/interfacing/screen/{id}
```

Remains a legacy workspace/layout resolution route owned by `InterfacingController`.

## Host compatibility

`config/routes.yaml` is not imported by the standalone kernel, which imports `config/routes/*.yaml`. It is kept as a host-compatibility note only.

## Next recommended step

After route ownership is stable, split the overloaded `InterfacingController` into thin page controllers or provider-backed view builders.

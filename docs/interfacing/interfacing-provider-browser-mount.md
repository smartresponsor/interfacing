# Interfacing Provider Browser Mount (Wave 45)

Wave 45 is a browser-visible provider mount stabilization pass.

Canonical rules:

- Interfacing owns rendering.
- Bridge/routes/resources feed the provider surface.
- Ant Design ProComponents is the primary admin body provider.
- PrimeReact remains secondary/rich-facade only.
- Twig may emit the provider document, schema payload, script wiring, and boot status marker.
- Twig must not render Bootstrap/external admin generator/handmade CSS/admin tables as the UI.

Runtime changes:

- `resourceContract.dataSource.items` carries server-provided workbench rows to the React provider.
- Provider adapters retry registration when the canonical provider bundle announces readiness.
- Runtime waits for provider registration instead of silently ending in an invisible required-provider state.
- The boot marker is intentionally a loading/diagnostic marker, not an alternate UI. It is replaced by the Ant Design ProComponents renderer after hydration.

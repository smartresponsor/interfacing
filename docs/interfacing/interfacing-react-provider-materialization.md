# Interfacing React Provider Materialization

## Decision

Interfacing keeps Ant Design ProComponents as the primary provider vocabulary and PrimeReact as the secondary facade provider. Tailwind and daisyUI are not introduced in this slice.

## Runtime contract

Provider JavaScript stays opt-in through `interfacing_provider_external_assets_enabled`. Twig rendering remains readable when the host does not expose public provider assets.

When external assets are enabled, the shell loads:

- `public/provider/canonical-providers.interfacing-interface-ui.css`
- `public/provider/provider-registry.js`
- `public/provider/canonical-providers.js`
- `public/provider/providers/antd-pro.js`
- `public/provider/providers/primereact.js`
- `public/provider/runtime.js`

## Build workspace

The React provider source lives under `.interfacing/workspace` and is intentionally package-owned.

```bash
npm ci
npm run ui:check
npm run ui:build
```

`npm run ui:build` writes provider bundles to `public/provider` with stable entry names that match the Twig asset manifest.

## Implemented providers

### Ant Design ProComponents

- `navigation-menu`
- `domain-workbench`
- `domain-surface`
- `workbench`
- `provider-handoff`

### PrimeReact

- `navigation-menu`
- `domain-diagnostic-card`
- `diagnostic-card`
- `domain-surface`
- `workbench`

## Bootstrap cleanup

Access/security templates no longer use Bootstrap-like classes such as `row`, `col-*`, `card`, `card-body`, `btn`, `alert`, `badge`, `table`, `form-control`, `form-label`, spacing helpers, or flex helpers. They now use Interfacing-owned semantic classes backed by the provider baseline stylesheet.

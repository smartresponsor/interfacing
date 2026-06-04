# Interfacing provider design baseline

Interfacing owns a provider-neutral visual baseline for shell, access, storefront, and provider-rendered screens.

The baseline intentionally does not depend on or name external admin generators. It captures a compact admin/workbench visual profile through neutral design tokens and maps those values to the providers Interfacing already supports.

## Runtime contract

- `templates/shell/partial/provider_baseline_style.html.twig` defines the canonical CSS variables and shell baseline styling.
- `templates/shell/base.html.twig`, `templates/access/base.html.twig`, `templates/application/dashboard.html.twig`, and `templates/base.html.twig` include the same baseline.
- `public/interfacing/design/provider-baseline.css` and `public/interfacing/design/provider-baseline-tokens.js` mirror the values for provider-only bootstraps.

## Provider mapping

### Ant Design ProComponents

Use `window.InterfacingProviderDesignBaseline.antDesign.token` as the `ConfigProvider` theme token input. The important normalized values are:

- system UI font stack;
- base font size `14`;
- shell/compact text `12` to `13` through CSS;
- line height `1.5714285714`;
- strong text weight `600`;
- radius `6/8/10`;
- spacing scale `4/8/12/16/24`;
- control height `32/36`.

### PrimeReact

Use `window.InterfacingProviderDesignBaseline.primeReact.cssVariables` or the equivalent `:root` variables. The important mapped variables are:

- `--font-family`;
- `--font-size`;
- `--text-color`;
- `--text-color-secondary`;
- `--primary-color`;
- `--surface-ground`;
- `--surface-card`;
- `--surface-border`;
- `--inline-spacing`;
- `--border-radius`;
- `--focus-ring`.

## Boundary

This is a measurement-inspired token layer, not inheritance from a third-party admin bundle. Interfacing remains independent and renders through its own shell and provider contracts.


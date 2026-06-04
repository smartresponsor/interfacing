# Interfacing native provider style cleanup

This cleanup moves the active Interfacing shell, access pages, commerce storefronts, and messaging showcase away from inline CSS.

## Canon

- Twig templates own structure, slots, semantic class names, and component payload rendering.
- Design values live in `public/design/provider-baseline.css`.
- Provider renderers consume `public/design/provider-baseline-tokens.js`.
- Inline CSS is forbidden in the core runtime templates guarded by `tools/interfacing/native-provider-style-guard.php`.
- This layer does not import, inherit, or name any external admin bundle.

## Why this matters

Inline style attributes override normal CSS and make provider-token tuning ineffective. Moving layout, spacing, typography, borders, radii, and control dimensions into the native provider baseline allows Ant Design/ProComponents and PrimeReact-facing renderers to receive a coherent design baseline without template-level repainting.

## Current scope

Guarded templates include:

- host shell base
- quick menu
- single-source footer
- sign-in/sign-up/sign-out access shell
- product/category/project storefront templates and cards
- messaging showcase and message card

Older diagnostic/demo templates may still contain legacy inline styles until they are migrated or deleted.

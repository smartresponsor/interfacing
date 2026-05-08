# Docs Manifest

Current normative documentation for this repository:
- `docs/interfacing.md`
- `docs/interfacing-quick-start.md`
- `docs/interfacing-dev-ergonomics.md`
- `docs/interfacing-category-integration.md`
- `docs/interfacing-doctor.md`
- `docs/interfacing-observability.md`
- `docs/interfacing-renderer-contract.md`

Remove stale sketch and stabilization notes instead of treating them as active architecture canon.

- docs/interfacing/interfacing-canonical-crud-directory.md
- `docs/interfacing/interfacing-admin-body-contract-index.md`
- `docs/interfacing/interfacing-admin-body-consumer-guide.md`
- `docs/interfacing/interfacing-admin-body-guard-consolidation.md`
- `docs/interfacing/interfacing-admin-body-residual-audit-cleanup.md`
- `docs/interfacing/interfacing-admin-body-rc-readiness-gate.md`
- `docs/interfacing/interfacing-admin-body-ui-provider-canon.md`
- docs/interfacing/interfacing-admin-body-strict-provider-rendering.md
- `docs/interfacing/interfacing-visible-page-provider-adoption-audit.md`
- `docs/interfacing/interfacing-visible-page-provider-adoption-runner.md`
- `docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md`

- `docs/interfacing/interfacing-admin-body-frontend-build-hardening.md`
- docs/interfacing/interfacing-visible-page-provider-migration.md — Visible page migration to canonical provider-owned body.
- `docs/interfacing/interfacing-consumer-provider-migration-executor.md` — consumer visible page migration executor for provider-owned UI adoption.

- Bridge provider surface: Bridge owns route/resource adoption; Interfacing renders provider-owned UI; direct consumer template rewrite is not the primary path.
- docs/interfacing/interfacing-bridge-provider-surface.md — bridge-owned route/resource provider surface.
- Wave 43 provider document: visible bridge/provider routes use `template/interfacing/admin/body/provider_document.html.twig` so e-commerce URLs render through the provider canvas instead of legacy shell chrome.

- Wave 44 visible provider adoption: `/interfacing`, shell Catalog navigation, and existing `/category/`/`/product/` visible catalog roots must resolve to the provider document/canonical provider asset chain instead of the old Generic CRUD workbench.

- `docs/interfacing/interfacing-provider-browser-mount.md` — Wave 45 browser-visible provider mount stabilization.

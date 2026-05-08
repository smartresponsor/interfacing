# Interfacing bridge provider surface

Bridge owns route/resource adoption. Interfacing renders provider-owned UI.
Consumer components own business metadata and behavior; they do not need to hand-code admin tables, forms, Bootstrap-like shells, or local CSS in visible pages.

## Canonical flow

```text
Cataloging / Cruding / Vendoring / other component
  -> Bridge maps route + resource + operation
    -> Interfacing bridge provider surface
      -> Interfacing admin body mount/schema
        -> Ant Design ProComponents primary renderer
        -> PrimeReact secondary rich-facade provider
```

The bridge-facing template is:

```text
template/interfacing/bridge/provider_surface.html.twig
```

The bridge-facing controller endpoint is:

```text
/interfacing/bridge/provider/{resourcePath}
```

This endpoint is a proving and integration surface. Production HostHub/Bridge code can render the template directly or route through the endpoint while keeping resource ownership in the bridge/interfaces layer.


## Visible route adoption

Visible e-commerce routes such as `/catalog/`, `/crud/`, `/cruding/`, `/vendor/`, and `/vendoring/` are adopted by Bridging route configuration, not by direct consumer template rewrites. The expected Bridging route config is `config/component/routes.yaml`, and it should route those visible URLs to the bridge controller that renders this Interfacing template.

Interfacing keeps `/interfacing/bridge/provider/{resourcePath}` as the stable provider surface and proof endpoint. Bridging may render the template directly for production-visible routes while preserving the same provider schema and ownership boundaries.

## Non-goals

Direct consumer template rewrite is not the primary path. The old migration executor remains an explicit repair/audit tool only and requires `--force-direct-template-rewrite` before it writes into sibling repositories.

Forbidden bridge output markers:

- `<table`
- `<form`
- `<style`
- `btn btn-`
- `container-fluid`
- `class="row"`

## Required provider ownership

- Ant Design ProComponents is the primary admin/workbench provider.
- PrimeReact is the secondary rich-facade provider.
- Twig owns shell, mount attributes, and schema payload only.


## Wave 42 runtime ownership

Visible e-commerce URLs must be visibly usable, not merely testable. Interfacing therefore imports `BridgeProviderSurfaceController` into `config/routes/interfacing_attributes.yaml` and exposes a high-priority provider surface route for `/catalog`, `/crud`, `/cruding`, `/vendor`, and `/vendoring` while Bridge route import is being wired into host applications.

The broad `zz_interfacing_crud_bridge.yaml` generic workbench route must exclude those visible provider roots. If `/catalog/`, `/cruding/`, or `/vendor/` resolve to `GenericCrudWorkbenchController::show`, runtime adoption is broken even if static guards are green.

The browser-visible body is rendered by the canonical provider chain:

```text
Twig shell + JSON schema + mount
  -> public/interfacing/admin-body/canonical-providers.js
  -> Ant Design ProComponents primary workbench
  -> PrimeReact secondary rich-facade event/provider
```

The surface may provide minimal seed rows and resource metadata so the e-commerce UI is immediately visible during bridge adoption. Those rows are provider payload, not Twig-rendered fallback UI.

## Wave 43 provider document

Visible provider routes use a provider-only document template:

```text
template/interfacing/admin/body/provider_document.html.twig
```

This document is intentionally not the legacy Interfacing shell base. The old shell base still exists for diagnostics and legacy Interfacing pages, but visible e-commerce provider routes must not inherit shell chrome that makes `/catalog/`, `/cruding/`, or `/vendor/` look like the old Twig workbench.

The visible provider document owns only HTML document metadata and canonical asset wiring. The screen body is still produced by the admin body mount and Ant Design ProComponents primary provider, with PrimeReact available only as the secondary rich-facade provider. It must not add Bootstrap, EasyAdmin, handmade CSS, Twig tables, Twig forms, or fallback visual markup.


## Wave 44 visible navigation adoption

A green `router:match /catalog/` is insufficient when operators still click old shell links such as `/category/`. Existing e-commerce navigation must point at provider-owned visible resources such as `/catalog/category/`, `/catalog/product/`, and `/vendor/`.

Interfacing `/interfacing` also renders the provider document for the e-commerce workbench so the main page is visually distinguishable from the old shell. Static provider assets are cache-busted with the Wave 44 provider adoption version marker to avoid stale browser JavaScript/CSS hiding the new Ant Design ProComponents render path.

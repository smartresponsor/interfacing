# Interfacing category storefront route repair

## Problem

`/catalog/category/` was still rendered by the generic bridge/provider fallback. The visible body showed `Bridge visible route`, route context, columns, and product-oriented demo records instead of a customer-facing category storefront.

## Decision

Catalog Category is a user-facing commerce surface. It must not fall through to the generic bridge/debug surface. The category route now has the same storefront contract as Product and Project:

- explicit controller route for `/catalog/category`, `/catalog/category/`, `/category`, and `/category/`;
- provider-owned placeholder data;
- Twig-owned storefront layout and reusable category card partial;
- bridge-level delegation as a defensive guard when the broad visible provider route catches the request.

## Runtime chain

```text
/catalog/category/
→ InterfaceCategoryShowcaseController
→ InterfaceCategoryShowcaseProviderInterface
→ InterfaceDemoCategoryShowcaseProviderService
→ catalog/category_showcase.html.twig
→ catalog/partial/category_card.html.twig
```

Defensive fallback:

```text
BridgeProviderSurfaceController visible path catalog/category
→ renderCategoryStorefront()
→ category showcase template
```

## Canon

The category page is a storefront/index page, not a CRUD/debug/route-context page. Temporary content may exist while Cataloging fixtures are absent, but it must live in a provider and remain replaceable by real Cataloging records later.

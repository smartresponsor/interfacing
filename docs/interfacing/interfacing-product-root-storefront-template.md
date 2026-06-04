# Product root storefront template

The `/product` and `/product/` routes are now canonical storefront routes for the Product browsing surface. They intentionally bypass the bridge/debug provider page that exposes route context, columns, and records.

The storefront remains provider-driven:

- `InterfaceProductShowcaseController` owns the canonical `/product` and compatibility `/catalog/product` route bindings.
- `InterfaceProductShowcaseProviderInterface` is the data seam.
- `InterfaceDemoProductShowcaseProviderService` supplies temporary product cards, price-profile-like values, promotion badges, and merchandising sections while real Cataloging/Producting records are absent.
- Twig templates own layout only: hero, controls, storefront sections, and reusable product cards.

This keeps the page suitable for the current development phase without hardcoding legacy/demo records directly in Twig. Future Cataloging/Producting integration should replace the demo provider, not the storefront templates.

Current storefront sections:

- Top products
- Discount products
- New arrivals
- Intellectual products

The same pattern should be reused for Category and Project storefront pages.

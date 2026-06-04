# Interfacing Product Storefront Showcase

## Decision

`/catalog/product/` now has an Interfacing-owned storefront showcase route that renders a customer-facing product surface instead of a provider/admin table.

The page is intentionally backed by a PHP provider, not Twig-embedded records:

- `InterfaceProductShowcaseProviderInterface` defines the data contract.
- `InterfaceDemoProductShowcaseProviderService` supplies temporary demo cards.
- `InterfaceProductShowcaseController` renders the route.
- `product_showcase.html.twig` owns the storefront/masonry layout.
- `partial/product_card.html.twig` owns the reusable product card template.

This keeps the current page useful while Cataloging/Producting data and fixtures are still absent, without locking placeholder data into the visual template.

## Scope

The Product page is the first storefront surface. Category and Project storefronts should reuse the same pattern:

1. provider interface for records and filters;
2. demo provider while the component has no records;
3. route-specific controller;
4. shared storefront/card partials when the shape converges.

## Shell behavior

The page inherits the standard application shell and should use the current unified top menu, left business navigation, and single footer partial.


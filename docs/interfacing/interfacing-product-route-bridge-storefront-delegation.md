# Product route bridge storefront delegation

The visible `/product` route may be reached through the broad bridge/provider route before the dedicated InterfaceProductShowcaseController in some host route-import orders.

To prevent the customer-facing product page from falling back to the bridge/debug provider surface, BridgeProviderSurfaceController now delegates canonical product index routes to the same storefront template and provider used by the InterfaceProductShowcaseController.

Canonical storefront paths:

- `/product`
- `/product/`
- `/catalog/product`
- `/catalog/product/`

The bridge fallback must remain available for provider/admin surfaces, but product index browsing is a customer-facing storefront surface and must render `product/product_showcase.html.twig`.

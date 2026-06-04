# Product storefront service wiring fix

The visible `/product` route is intercepted by `BridgeProviderSurfaceController` in host runtime before the direct storefront controller can respond. The controller therefore needs the same explicit product showcase provider wiring as `InterfaceProductShowcaseController`.

This repair makes `InterfaceProductShowcaseProviderInterface` an explicit constructor argument for both storefront controllers and includes the provider interface/provider/template dependency set in the touched patch so an overlay cannot leave the host container with a null constructor argument.

Canonical dependency chain:

```text
/product
→ BridgeProviderSurfaceController when broad visible route wins
→ InterfaceProductShowcaseProviderInterface
→ InterfaceDemoProductShowcaseProviderService until Cataloging provides live records
→ product/product_showcase.html.twig
```

The controller must never receive `null` for the product showcase provider.

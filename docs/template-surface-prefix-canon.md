# Interfacing template surface prefix canon

Interfacing owns UI template surfaces, not ecosystem component ownership.

Canonical runtime templates live directly under `templates/`:

- `templates/shell/`
- `templates/admin/body/`
- `templates/provider/`
- `templates/catalog/`
- `templates/product/`
- `templates/cart/`
- `templates/checkout/`
- `templates/payment/`
- `templates/order/`
- `templates/attachment/`
- `templates/currency/`
- `templates/account/`
- `templates/system/`

Forbidden runtime root:

- `templates/interfacing/`
- `templates/commerce/`

The component name belongs to package/configuration namespace, not to a nested runtime template folder inside this repository.

Surface folders such as `payment`, `attachment`, and `currency` mean UI patterns only. They do not prove or imply that Interfacing owns Paying, Attaching, or Currencing business logic.


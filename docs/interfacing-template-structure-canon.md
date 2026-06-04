# Interfacing template structure canon

Interfacing owns UI template surfaces, not ecosystem component ownership.

## Canonical runtime root

Runtime Twig templates live directly under `templates/`. The repository name is not repeated inside its own template root.

Canonical examples:

```text
templates/shell/
templates/provider/
templates/admin/body/
templates/provider/
templates/crud/
templates/catalog/
templates/product/
templates/project/
templates/cart/
templates/checkout/
templates/payment/
templates/order/
templates/attachment/
templates/currency/
templates/account/
templates/system/
```

## Forbidden runtime shape

`templates/interfacing/`, `templates/*ing/`, and component-name roots are not canonical runtime surface roots. They make Interfacing look like it mirrors ecosystem components and create ambiguous shell inheritance.

## Meaning of surface folders

Folders such as `catalog`, `payment`, `attachment`, or `currency` are UI surface names. They are not ownership declarations for Cataloging, Paying, Attaching, or Currencing.

Owner component metadata, when needed, must come from provider/host/producer metadata and not from Interfacing folder names.

## Base chain

All shell-visible pages converge to:

```text
templates/base.html.twig
```

`templates/base.html.twig` is the single canonical document base. `templates/shell/base.html.twig` is retired and must not be reintroduced as a parallel document owner.


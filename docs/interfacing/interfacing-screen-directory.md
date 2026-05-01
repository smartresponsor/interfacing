# Interfacing screen directory

The screen directory is the shell-native operator map for every known e-commerce screen/action link exposed through Interfacing.

## Boundary

Interfacing owns shell frame, navigation, CRUD URL grammar, status display, and empty/error/loading rendering contracts.

Interfacing does not own business demo rows, component fixtures, component-specific records, or fake catalog/order/billing/messaging data. Those records must come from the owning Smart Responsor component fixtures, APIs, providers, or host integration.

## Route

```text
/interfacing/screens
```

The workspace still embeds the compact e-commerce matrix at:

```text
/interfacing#ecommerce-screen-matrix
```

## Statuses

- `connected`: connected through Interfacing or a known host route.
- `canonical`: follows canonical CRUD grammar, backing component may not be connected yet.
- `planned`: known ecosystem component/resource intentionally visible for navigation planning.

## CRUD grammar

```text
/{resourcePath}/
/{resourcePath}/new/
/{resourcePath}/{id|slug}
/{resourcePath}/edit/{id|slug}
/{resourcePath}/delete/{id|slug}
```

Show/edit/delete sample links use a sample identifier. Real identifiers belong to the owning component.

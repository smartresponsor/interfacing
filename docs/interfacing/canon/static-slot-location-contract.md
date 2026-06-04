# Static slot/location contract

Interfacing is an inert templates/layout package from the outside.

Producer components own business logic, template lookup decisions, fallback decisions, and data preparation. Interfacing provides template trees, base inheritance, reusable Twig partials, provider assets, and stable slot/location names.

Interfacing must not provide a live component resolver, business-aware dispatcher, component registry, or template lookup service as the general integration path.

## Canonical shell locations

Document/body:

- `shell.body.top`

Header:

- `shell.header.left.logo`
- `shell.header.left.name`
- `shell.header.left.title`
- `shell.header.context`
- `shell.header.main`
- `shell.header.right.user`
- `shell.header.right.cart`
- `shell.header.right.notification`
- `shell.header.right.toggle`
- `shell.header.bottom`

Left primary column:

- `shell.left.top`
- `shell.left.middle`
- `shell.left.bottom`

Left context column:

- `shell.context.top`
- `shell.context.middle`
- `shell.context.bottom`

Main/content column:

- `shell.main.top`
- `shell.main.toolbar`
- `shell.main.content`
- `shell.main.bottom`

Right column:

- `shell.right.top`
- `shell.right.tool`
- `shell.right.filter`
- `shell.right.middle`
- `shell.right.bottom`

Footer:

- `shell.footer.top`
- `shell.footer.left`
- `shell.footer.context`
- `shell.footer.main`
- `shell.footer.right`

## Template-side usage

Templates render location arrays by reading the `locations` variable and including the shared provider bucket partial:

```twig
{% include 'shell/partial/location_bucket.html.twig' with {
  location: 'shell.main.content',
  items: locations['shell.main.content']|default([])
} only %}
```

Legacy aliases are retired from active runtime rendering. Producer components must normalize payloads before passing data to Interfacing.

## Producer-side usage

A producer component may look for Interfacing templates by its own convention. Example candidate order for a `payment` surface can be:

1. `payment/index.html.twig`
2. `payment/default.html.twig`

The producer owns that lookup. Interfacing does not perform it for producers.

If no template is found, the producer may return structured data arrays to its caller instead of rendering Interfacing.

## Forbidden in Interfacing

- Component owner inference such as `payment => paying`.
- A central live template resolver service.
- A component registry used to decide business ownership.
- Route/controller logic that selects templates for external producer components.
- Physical `*ing` template folders.
- Legacy location aliases such as `left.primary.menu`, `body.content`, `right.context`, or `footer.primary` in active runtime source.

## Allowed in Interfacing

- Static Twig inheritance.
- Static Twig blocks and includes.
- Shared partials/macros for repeated shell pieces.
- Noun-based surface template folders.
- Documentation and guards enforcing the slot names.


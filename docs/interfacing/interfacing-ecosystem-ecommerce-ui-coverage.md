# Interfacing ecosystem/e-commerce UI coverage

This document is the canonical page-coverage map for provider adoption. It is
not limited to the files present in one archive. Interfacing knows the ecosystem
surface that must become provider-rendered before the UI can be treated as
product-grade.

## Provider rule

All admin/workbench pages use the canonical provider chain:

- primary admin/workbench provider: **Ant Design + ProComponents** (`antd-pro`);
- secondary rich-facade provider: **PrimeReact** (`primereact`);
- Twig owns shell inheritance, mount node, schema payload, and script wiring only.

No Bootstrap direction, no handmade Twig/CSS admin body, no fallback admin UI.
If a page has no canonical provider mount, that is an adoption gap.

## Canonical component map

| Component | Required UI coverage |
| --- | --- |
| App / HostHub | hosthub home, admin dashboard, public storefront entry |
| Interfacing | provider shell, provider body contract, screen directory, diagnostics |
| Cruding | generic resource CRUD, category/product/catalog-style management |
| Objecting | object field packs, title fields, metadata management |
| Cataloging | catalog, category, product, storefront listings |
| Tagging | tags, taxonomy, classification surfaces |
| Paging | page management, page previews |
| Vendoring | vendors, supplier/account/payout surfaces |
| Ordering | cart/checkout, orders, customer order history |
| Paying | payments, refunds, payment provider operations |
| Shipping | fulfillment, shipment tracking, shipping rates |
| Taxating | sales-tax/VAT rules and transaction-tax configuration |
| Currencing | currency metadata, money formatting, minor units |
| Messaging | inbox, notifications, customer/vendor threads |
| Locating | addresses, locations, service areas |
| Indexing | search index management and diagnostics |

## E-commerce page families

The provider-adoption milestone must account for these page families:

- admin dashboard;
- catalog management;
- category management;
- product management;
- tag/taxonomy management;
- vendor management;
- order management;
- payment/refund management;
- shipping/fulfillment management;
- tax/currency configuration;
- message center;
- location/address management;
- search/index diagnostics;
- public storefront;
- cart/checkout;
- customer account and order history.

## Audit command

```bash
php tools/interfacing/admin-body-ecosystem-ui-coverage-audit.php
```

The audit does not require every consumer repository to be present. Missing
repositories are reported as adoption gaps, not as a reason to forget the page
family.

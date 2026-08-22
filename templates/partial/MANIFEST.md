# Interfacing partial templates

Shared Twig fragments used by noun-view templates.

Rules:

- `partial/` is for reusable fragments only.
- Surface folders such as `cart/`, `product/`, `order/`, and `vendor/` own page/operation templates.
- Partials must not own business routing, Symfony controllers, or producer logic.
- Partials may expose stable `data-ui-zone` hooks for future Ant Design, ProComponents, or PrimeReact enrichment.
- `status_timeline.html.twig` — chronological status/event rendering for orders, payments, refunds and transactions.
- `payment_status_panel.html.twig` — payment state and payment detail panel.
- `invoice_panel.html.twig` — invoice summary/detail panel.
- `refund_panel.html.twig` — refund records panel.
- `transaction_ledger.html.twig` — reusable transaction history/ledger renderer.
- `payout_statement_panel.html.twig` — vendor payout statement summary panel.

Scope
- Gate B focus: real HTTP-backed data for Billing and Order Interfacing screens.

Design
- Keep Billing/Order domain boundaries:
  - Interfacing only depends on HTTP API (no direct DB).
  - Endpoints configurable via env.
- Provide stable DTOs in Interfacing domain for UI consumption:
  - BillingMeterRow/BillingMeterPage
  - OrderSummaryRow/OrderSummaryPage
- Provide ServiceInterface layer for Interfacing runtime:
  - BillingMeterQueryServiceInterface
  - OrderSummaryQueryServiceInterface

Integration
- Bind Interfacing screen providers:
  - Screen "billing-meter" -> BillingMeterQueryInterface::fetchPage(...)
  - Screen "order-drill" (summary grid) -> OrderSummaryQueryInterface::fetchPage(...)

SLO
- Target for HTTP calls:
  - p95 <= 250ms
  - error-rate < 0.5%
- These values are not enforced here but should be monitored in the Billing/Order domains.

Scope
- Gate C: end-to-end Interfacing screens for Billing and Order domains.

Flow (Billing)
- Request: GET /interfacing/billing/meter
- Context:
  - tenantId, userId resolved via BaseContextProviderInterface
- Access:
  - canOpenScreen("billing-meter", request, token)
- Data:
  - BillingMeterQueryServiceInterface::fetchPage(tenantId, page, pageSize, status, periodFrom, periodTo)
- View:
  - meter.html.twig renders filters, grid and pager
- Audit:
  - AuditEventType::ScreenOpen with screenId "billing-meter"

Flow (Order)
- Request: GET /interfacing/order/summary
- Context:
  - tenantId, userId via BaseContextProviderInterface
- Access:
  - canOpenScreen("order-summary", request, token)
- Data:
  - OrderSummaryQueryServiceInterface::fetchPage(tenantId, page, pageSize, status, createdFrom, createdTo)
- View:
  - summary.html.twig renders filters, grid and pager
- Audit:
  - AuditEventType::ScreenOpen with screenId "order-summary"

SLO notes
- These screens are thin; main SLO impact is in:
  - Billing and Order APIs called by Stab-2 services
  - Interfacing AccessResolver / audit log sink
- UI is intentionally simple and server-driven (no SPA required).

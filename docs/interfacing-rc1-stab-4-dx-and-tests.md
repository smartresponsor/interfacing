Scope
- Strengthen Interfacing RC1 with:
  - Developer-facing console commands.
  - Extra tests for HTTP-backed query services.

DX design
- parameter "interfacing.screens":
  - Small, explicit map of known Interfacing screens.
  - Used only by DX commands; runtime is not coupled to it.

- interfacing:screen:dump:
  - Human-friendly overview of screens, routes and notes.
  - Intended for developers during debugging and onboarding.

- interfacing:screen:validate:
  - Checks that each entry in "interfacing.screens" has:
    - id
    - route
    - existing Symfony route.
  - Designed for CI gating:
    - If routes or configuration change, CI will fail early.

Testing design
- Tests keep focus on HTTP bindings (Stab-2 services):
  - Confirm query assembly:
    - paging
    - filters
    - tenant header.
  - Confirm payload parsing:
    - items -> Row DTOs
    - total, page, pageSize values.
  - Confirm failure behavior on non-200 status codes.

- Fake HttpClients:
  - Implement HttpClientInterface / ResponseInterface.
  - Enough behavior to cover usage in HttpBillingMeterQueryService / HttpOrderSummaryQueryService.

Result
- Interfacing RC1 is now better instrumented:
  - DX: easy to see screens and validate wiring.
  - Tests: HTTP bindings have concrete, reproducible coverage.

Recommended next step after Stab-4
- Extend tests to cover controllers + templates via kernel test case
  (or keep that for RC2 when Interfacing stabilizes as a product).

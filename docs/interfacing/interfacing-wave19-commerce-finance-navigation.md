# Interfacing wave19 — Commerce finance navigation and screen coverage

Wave19 adds first-class Interfacing navigation and CRUD screen catalog coverage for the newly introduced commerce finance components:

- Currencing
- Exchanging
- Subscripting
- Commissioning

## Boundary

Interfacing still owns only shell, navigation, route-transparent CRUD frames, screen catalogs and operator affordances. The owning components remain responsible for records, fixtures, persistence, identifiers, validation, policies, handlers, audit evidence and bridge wiring.

## Canonical e-commerce placement

These components are exposed under the existing `Billing and paying` e-commerce zone because they are adjacent to pricing, checkout, billing, payment, settlement and partner revenue workflows.

## Navigation

Wave19 adds a commerce finance section in the shell navigation for:

- currencies and money formatting;
- exchange rates and exchange quotes;
- subscriptions and subscription plans;
- commission plans and commission payouts.

The URLs intentionally use the existing generic CRUD bridge grammar, for example `/currency/`, `/exchange-rate/`, `/subscription/` and `/commission-plan/`.

## CRUD resource contributions

Each component receives a dedicated `CrudResourceDescriptorContributionInterface` implementation:

- `CurrencingCrudResourceContribution`
- `ExchangingCrudResourceContribution`
- `SubscriptingCrudResourceContribution`
- `CommissioningCrudResourceContribution`

This keeps resource metadata in component-named contribution classes instead of embedding ad hoc link lists in controllers or Twig templates.

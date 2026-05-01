# Interfacing e-commerce screen matrix

The e-commerce screen matrix is the operator-facing catalog for all known Smart Responsor commerce screens and CRUD action links.

## Rules

- Interfacing owns layout, navigation, route grammar visibility and operation affordances.
- Interfacing must not own business demo rows, fake orders, fake messages, fake products or fake invoices.
- Connected rows point to host-connected screens.
- Canonical rows point to known CRUD grammar for component resources that have a component-specific contribution.
- Planned rows point to known ecosystem resources that are intentionally visible before the component is connected.
- Show, edit and delete links may use a sample identifier; the owning component must provide real ids or slugs at runtime.

## Minimum commerce zones

- Platform
- Access
- Catalog and discovery
- Commercial and retail
- Ordering
- Billing and paying
- Tax and governance
- Fulfillment and location
- Messaging
- Documents and attachments
- Platform operations
- Supporting components

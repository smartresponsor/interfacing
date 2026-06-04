# Interfacing left navigation component/context contract

This wave separates the two left navigation panels by responsibility.

## Primary left panel

The primary left panel is now component-level only. It must expose top-level Smart Responsor ecosystem bricks and user-facing business components. It must not enumerate CRUD diagnostics, form builders, shell previews, route maps, tests, URL discovery entries, or secondary operations.

Examples:

- Catalog -> `/catalog/category/`
- Products -> `/product/`
- Projects -> `/project/`
- Messaging -> `/message/compose`
- Orders -> `/order/`
- Payments -> `/payment/`
- Shipping -> `/shipment/`

When a component is CRUD-index-like, the primary link points to the business index. When the component is action/workbench-like, such as Messaging, the primary link points to the most relevant business entry point.

## Secondary left panel

The secondary left panel is context-sensitive. It changes with the active component and carries lower-level links for the selected component.

Examples:

- Messaging: compose, inbox, outbox, notifications, rooms, chats, search/check, digest, message center.
- Catalog: categories, products, catalog search.
- Products: storefront, catalog product index, top products, discount products, new arrivals, intellectual products.
- Projects: storefront, intake, templates, active projects.

## Body

The body should render the component's index, storefront, compose surface, or other relevant entry page, depending on component semantics.

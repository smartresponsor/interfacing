# Interfacing admin body navigation policy contract

Wave 21 adds a local navigation contract for the central admin body area.

The global application navigation remains owned by the ecosystem shell. The admin body may only publish local resource context that belongs inside the body slot:

- `PageContainer.breadcrumb` for resource breadcrumbs.
- `PageContainer.extra.back` for the back-to-list action.
- `PageContainer.header.resourceContext` for the current resource label/scope.
- `PageContainer.header.routeContext` for the current CRUD operation/surface.

This avoids reintroducing local shell/menu duplication while still giving the Ant Design ProComponents renderer enough metadata to produce normal workbench navigation.

Required runtime behavior:

- `navigationPolicy` must exist in the schema payload.
- `globalNavigationOwner` must stay `ecosystem-shell`.
- Missing navigation policy data must stop hydration with `navigation-policy-error`.
- The Twig provider-less UI may show only local back/context hints, not a separate application menu.

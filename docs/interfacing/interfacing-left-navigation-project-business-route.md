# Interfacing left navigation project route audit

The left primary navigation must expose customer/business surfaces rather than workspace or component internals.

## Issue

The `Projects` item pointed to `/projection/`. That URL describes the Projecting workspace/projection capability, not the customer-facing project business surface. In a host application this can fall through a CRUD/provider resolver and produce a 404.

## Resolution

`Projects` now points to `/project/` in both primary and workspace-context navigation groups.

A customer-facing project storefront route was added:

- `/project`
- `/project/`

The route renders provider-backed project cards via:

- `InterfaceProjectShowcaseController`
- `InterfaceProjectShowcaseProviderInterface`
- `InterfaceDemoProjectShowcaseProviderService`
- `project_showcase.html.twig`
- `partial/project_card.html.twig`

The demo provider is a temporary source for storefront placeholders. It keeps project data outside Twig so a real Projecting/Cataloging provider can replace it later without changing the visual contract.

## Canon

- `Projecting` is a component/workspace capability.
- `Project` is the business storefront/entity-facing navigation item.
- Left primary navigation should link to `/project/`, not `/projection/`.

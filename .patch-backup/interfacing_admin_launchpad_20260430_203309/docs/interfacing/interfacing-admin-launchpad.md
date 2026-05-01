# Interfacing Admin Launchpad

The admin launchpad is the fastest operator entry point for e-commerce CRUD work. It groups known Smart Responsor resources by commerce zone and exposes the canonical `index`, `new`, `show`, `edit`, and `delete` actions for every resource available through the CRUD registry.

The page is intentionally shell-native and does not embed business demo rows. A `planned` card is still useful: it reserves the canonical URL grammar for a component that is known to the ecosystem but may not be connected by the host application yet.

## Data boundary

Interfacing owns navigation, shell layout, action affordances and route transparency. Business records, demo fixtures, permissions and persistence remain owned by the component that provides the resource.

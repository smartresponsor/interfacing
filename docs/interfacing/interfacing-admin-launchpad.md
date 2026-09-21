# Interfacing Admin Launchpad

The admin launchpad is an Interfacing-owned shell entry point for the EasyAdmin back-office surface. Generic application CRUD grammar, dispatch, and reusable CRUD routing remain owned by Cruding; Interfacing does not define a parallel generic CRUD registry or route family outside EasyAdmin.

The page remains shell-native and must not embed business demo rows or query sibling component state. Resource data, permissions, persistence, and business operations remain owned by the component that provides the resource.

## Boundary

Interfacing owns the admin shell, layout, presentation affordances, and EasyAdmin integration required by its explicit back-office runtime. Cruding owns generic application CRUD. Business data, fixtures, permissions, and persistence remain outside Interfacing.

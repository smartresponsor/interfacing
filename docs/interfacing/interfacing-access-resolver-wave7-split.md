# Interfacing boundary wave7 — AccessResolver split

Wave7 separates the overloaded `AccessResolverInterface` vocabulary into explicit Symfony-oriented contracts.

## Canonical contracts

- `ServiceInterface/Interfacing/Access/ScreenActionAccessResolverInterface.php` — request-aware access decisions for opening screens and running screen actions.
- `ServiceInterface/Interfacing/Access/RoleAccessResolverInterface.php` — legacy role-list access check used by older screen-spec rendering paths.
- `ServiceInterface/Interfacing/Security/ScreenAccessResolverInterface.php` — screen-spec access check used by the action dispatcher and screen-aware security services.
- `ServiceInterface/Interfacing/Shell/CapabilityAccessResolverInterface.php` — shell chrome capability check for navigation, layout, and panel visibility.

## Deprecated compatibility interfaces

The following files are retained as compatibility aliases only:

- `ServiceInterface/Interfacing/Access/AccessResolverInterface.php`
- `ServiceInterface/Interfacing/AccessResolverInterface.php`
- `ServiceInterface/Interfacing/Security/AccessResolverInterface.php`
- `ServiceInterface/Interfacing/Shell/AccessResolverInterface.php`

New code must not import these root/transitional names.

## Service binding

The DI configuration binds both canonical contracts and deprecated aliases to the existing concrete services. This keeps host-app runtime stable while new code moves to the exact contract names.

# Interfacing boundary wave7 — Screen authorization resolver split

Wave7 separates the overloaded authorization vocabulary into explicit Symfony-oriented contracts for UI screens, actions, and shell capability checks.

## Canonical contracts

- `ResolverInterface/Access/InterfaceScreenActionAccessResolverInterface.php` — request-aware authorization decisions for opening screens and running screen actions.
- `ResolverInterface/Access/InterfaceRoleAccessResolverInterface.php` — legacy role-list authorization check used by older screen-spec rendering paths.
- `ResolverInterface/Security/InterfaceScreenAccessResolverInterface.php` — screen-spec authorization check used by the action dispatcher and screen-aware security services.
- `ResolverInterface/Shell/InterfaceCapabilityAccessResolverInterface.php` — shell chrome capability check for navigation, layout, and panel visibility.

## Boundary clarification

These contracts protect Interfacing screen/action visibility only. They do not own authentication, account access, login, registration, logout, sessions, credentials, or `/access/*` routes.

## Deprecated compatibility names

Older generic resolver names are retired. New code must import the explicit capability-specific contract that matches the call site.

## Service binding

The DI configuration binds canonical contracts to the concrete resolver services. Host-app runtime stays stable while new code uses exact contract names.

# Interfacing wave8 — Screen authorization implementation dedup

Wave8 keeps the wave7 screen-authorization contract split and makes the concrete Symfony-backed implementations type-identifiable by service name.

## Canonical implementations

- `Resolver/Access/InterfaceSymfonyScreenActionAccessResolver.php` implements request-aware screen/action authorization decisions.
- `Resolver/Access/InterfaceSymfonyRoleAccessResolver.php` implements legacy role-list screen authorization checks.
- `Resolver/Security/InterfaceSymfonyScreenAccessResolver.php` implements screen-spec authorization checks.
- `Resolver/Shell/InterfaceSymfonyCapabilityAccessResolver.php` implements shell capability checks.
- `Resolver/Security/InterfaceAllowAllScreenAccessResolver.php` is the standalone fallback for screen-spec authorization.
- `Resolver/Shell/InterfaceAllowAllCapabilityAccessResolver.php` is the standalone fallback for shell capability checks.

## Boundary clarification

The `Resolver/Access` namespace is an internal Interfacing UI authorization namespace. It is not the Accessing component and must not be used for account login, registration, logout, session, credential, or `/access/*` route ownership.

## Runtime posture

The canonical resolvers remain standalone-friendly: if the Symfony authorization checker is not available, role, screen, and shell authorization resolvers allow by default rather than crashing. Host applications that need strict denial must bind a real authorization checker or replace the resolver service explicitly.

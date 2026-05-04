# Interfacing wave8 — Access implementation dedup

Wave8 keeps the wave7 access-contract split and makes the concrete Symfony-backed implementations type-identifiable by service name.

## Canonical implementations

- `Service/Interfacing/Access/SymfonyScreenActionAccessResolver.php` implements request-aware screen/action decisions.
- `Service/Interfacing/Access/SymfonyRoleAccessResolver.php` implements legacy role-list checks.
- `Service/Interfacing/Security/SymfonyScreenAccessResolver.php` implements screen-spec access checks.
- `Service/Interfacing/Shell/SymfonyCapabilityAccessResolver.php` implements shell capability checks.
- `Service/Interfacing/Security/AllowAllScreenAccessResolver.php` is the standalone fallback for screen-spec access.
- `Service/Interfacing/Shell/AllowAllCapabilityAccessResolver.php` is the standalone fallback for shell capability access.

## Compatibility classes retained

The older generic names remain as compatibility wrappers only:

- `Service/Interfacing/Access/SymfonyAccessResolver.php`
- `Service/Interfacing/SymfonyAccessResolver.php`
- `Service/Interfacing/Security/SymfonyAccessResolver.php`
- `Service/Interfacing/Shell/SymfonyAccessResolver.php`
- `Service/Interfacing/Security/AllowAllAccessResolver.php`
- `Service/Interfacing/Shell/AllowAllAccessResolver.php`

New DI aliases point at the canonical implementation names. The compatibility wrappers are kept to avoid breaking external consumers or older host-service references.

## Runtime posture

The canonical resolvers remain standalone-friendly: if the Symfony authorization checker is not available, the role/screen/shell access resolvers allow by default rather than crashing. Host applications that need strict denial must bind a real authorization checker or replace the resolver service explicitly.

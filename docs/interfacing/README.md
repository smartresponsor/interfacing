Interfacing (sketch-12)

Goal:
- Add two missing “production” pieces:
  1) Screen context assembly (request/user/env) with extensible resolvers.
  2) Security-aware access resolver (Symfony isGranted / voters) that consumes host security services.

What you get:
- BaseContextProviderInterface + RequestBaseContextProvider (request/query/locale + optional security token info).
- ScreenContextResolverInterface + ScreenContextAssembler (tagged resolvers).
- SymfonyAccessResolver (AuthorizationCheckerInterface) with simple capability parsing:
  - role:ROLE_ADMIN
  - attr:some_attribute
  - otherwise: treat as attribute directly.

Default behavior:
- Interfacing does not own firewall or access-control configuration.
- Host application security remains canonical; Interfacing only consumes host security services through access-resolver abstractions.
- Package-level security.yaml is intentionally absent.

Drift guard (RVE-A6):
- tools/interfacing-drift-check.php enforces Interfacing boundaries.
- Forbidden: Domain rules, policy decisions, cross-domain coupling.
- Gate: CI can run `php tools/interfacing-drift-check.php`.

Namespace canon (RVE-B12):
- Symfony-standard namespace prefix is App\\ for this repo.
- Forbidden: SmartResponsor\\* and SR\\* prefixes in namespaces/imports.
- Drift guard enforces App\\ usage in Interfacing boundary files.

Drift guard (RVE-A6):
- tools/interfacing-drift-check.php enforces Interfacing boundaries.
- Forbidden: Domain rules, policy decisions, cross-domain coupling.
- Gate: CI can run `php tools/interfacing-drift-check.php`.

UI contract:
- docs/interfacing/ui-contract.yaml (explicit screen contracts; I/O + error semantics).

Routes:
- /interfacing
- /interfacing/{id}

CLI:
- php bin/console interfacing:doctor            # human (primary)
- php bin/console interfacing:doctor-json       # machine-readable JSON
- php bin/console interfacing:doctor-summary    # legacy summary (kept for compatibility)
- php bin/console interfacing:permission-sample # permission naming samples
- php bin/console interfacing:doctor-json

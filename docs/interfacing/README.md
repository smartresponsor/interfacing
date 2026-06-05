Interfacing

Goal:
- Provide reusable Symfony-oriented UI composition, shell, layout, screen, and rendering primitives.
- Provide screen/action/shell authorization adapters that consume host security services without owning account/security flows.

What you get:
- InterfaceBaseContextProviderInterface + InterfaceRequestBaseContextProviderService (request/query/locale + optional security token info).
- InterfaceScreenContextResolverInterface + InterfaceScreenContextAssemblerService (tagged resolvers).
- Explicit resolver contracts for screen/action authorization and shell capability checks.

Default behavior:
- Interfacing does not own firewall, account, login, logout, credential, session, or access-control configuration.
- Host application security remains canonical; Interfacing only consumes host security services through screen/action/shell authorization abstractions.
- Package-level security.yaml is intentionally absent.

Drift guard:
- tools/interfacing-drift-check.php enforces Interfacing boundaries.
- Forbidden: domain rules, policy decisions, cross-domain coupling, account route ownership.
- Gate: CI can run `php tools/interfacing-drift-check.php`.

Namespace canon:
- Symfony-standard namespace prefix is App\ for this repo.
- Forbidden: SmartResponsor\* and SR\* prefixes in namespaces/imports.
- Drift guard enforces App\ usage in Interfacing boundary files.

UI contract:
- docs/interfacing/ui-contract.yaml (explicit screen contracts; I/O + error semantics).

Routes:
- /interfacing
- /interfacing/{id}

CLI:
- php bin/console interfacing:doctor            # human (primary)
- php bin/console interfacing:doctor-json       # machine-readable JSON
- php bin/console interfacing:doctor-summary    # screen/layout summary
- php bin/console interfacing:permission-sample # permission naming samples

# Access/action compatibility alias retirement

Wave 8 retires the remaining access/action compatibility wrappers before the component has public end-user compatibility commitments.

Canonical contracts are capability-specific:

- `Access/InterfaceScreenActionAccessResolverInterface` for request-aware screen and action checks.
- `Access/InterfaceRoleAccessResolverInterface` for legacy role-list screen access.
- `Security/InterfaceScreenAccessResolverInterface` for declarative `InterfaceScreenSpec` checks.
- `Shell/InterfaceCapabilityAccessResolverInterface` for shell chrome capability checks.
- `Catalog/InterfaceActionEndpointCatalogInterface` for action endpoint catalog lookup.

The following names are retired and must not be reintroduced:

- root `AccessResolverInterface`
- `Access/AccessResolverInterface`
- `Security/AccessResolverInterface`
- `Shell/AccessResolverInterface`
- root `InterfaceActionCatalogInterface`
- `SymfonyAccessResolver` wrapper classes in `Access`, `Security`, and `Shell`
- `AllowAllAccessResolver` wrapper classes in `Security` and `Shell`

Use direct canonical service aliases in `config/services/interfacing.yaml`. Do not keep duplicate wrapper classes solely to preserve internal historical names.

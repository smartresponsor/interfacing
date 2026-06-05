# Screen authorization/action alias retirement

Wave 8 retires the remaining generic authorization/action compatibility aliases before the component has public end-user compatibility commitments.

Canonical contracts are capability-specific:

- `ResolverInterface/Access/InterfaceScreenActionAccessResolverInterface` for request-aware screen and action checks.
- `ResolverInterface/Access/InterfaceRoleAccessResolverInterface` for legacy role-list screen authorization.
- `ResolverInterface/Security/InterfaceScreenAccessResolverInterface` for declarative `InterfaceScreenSpec` checks.
- `ResolverInterface/Shell/InterfaceCapabilityAccessResolverInterface` for shell chrome capability checks.
- `Catalog/InterfaceActionEndpointCatalogInterface` for action endpoint catalog lookup.

The following names are retired and must not be reintroduced:

- root generic resolver interfaces
- generic `AccessResolverInterface` aliases
- generic `SymfonyAccessResolver` wrapper classes
- generic `AllowAllAccessResolver` wrapper classes
- root `InterfaceActionCatalogInterface`

Use direct canonical service aliases in `config/services/interfacing.yaml`. Do not keep duplicate wrapper classes solely to preserve internal historical names.

Boundary: this document is about Interfacing screen/action authorization only. It is unrelated to the Accessing component and must not justify Interfacing ownership of account, login, logout, or `/access/*` routes.

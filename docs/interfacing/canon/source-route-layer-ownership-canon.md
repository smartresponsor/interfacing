# Source route and layer ownership canon

Interfacing is a templates/layout/rendering component. It may expose scoped diagnostics, demo, showcase, handoff, and internal CRUD routes under `/interfacing/*`, but it must not own business-looking public routes such as `/product`, `/project`, `/category`, `/message`, `/access`, `/sign-up`, or `/sign-out`.

No exception: the account/security component owns `/access/*`, including sign-in page routes, credential-processing POST routes, registration, logout, and session/security routes. Interfacing must not register account routes or depend on foreign account/security runtime services.

Producer components own business public URLs. Interfacing owns the shell, provider-native render surfaces, slot/location contract, and optional scoped showcase/demo routes.

## Route rule

Allowed Interfacing routes use the component prefix:

```text
/interfacing/*
```

Forbidden routes in Interfacing controllers:

```text
/product
/project
/category
/catalog/product
/catalog/category
/message
/access
/sign-up
/sign-out
/compliance
```

## Symfony layer rule

Symfony voters belong in `src/Voter/`, not in `src/Application/Security/`. Application security may own permission value objects/constants, but the framework voter is a Symfony integration artifact and must remain type-identifiable by folder.

## Interface placement rule

Interfaces must not live in implementation folders such as `Presentation/LiveComponent`, `Integration/Twig`, or `Support/Doctor`. They must live in `ServiceInterface` or another explicit contract/interface layer matching their responsibility.


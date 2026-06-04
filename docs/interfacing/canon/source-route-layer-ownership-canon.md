# Source route and layer ownership canon

Interfacing is a templates/layout/rendering component. It may expose scoped diagnostics, demo, showcase, handoff, and internal CRUD routes under `/interfacing/*`, but it must not own business-looking public routes such as `/product`, `/project`, `/category`, `/message`, `/access`, `/sign-up`, or `/sign-out`.

Exception: the public access welcome surface `GET /access/signin` is a shared entrypoint for the access flow. Interfacing owns the visual response, while Accessing owns the credential-processing POST route on the same canonical path.

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


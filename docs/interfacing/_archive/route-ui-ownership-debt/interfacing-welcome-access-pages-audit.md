# Interfacing welcome access pages audit

## Scope

This audit covers the Interfacing responsibility for public welcome pages related to account access: Sign-in, Sign-up, and Sign-out.

## Decision

Interfacing owns the visual page contract for these pages, not authentication, registration, logout execution, password policy, user persistence, or session invalidation.

The canonical Interfacing responsibility is:

- public welcome/access page layout;
- footer-only shell variant;
- no application top panel;
- no primary or secondary left panels;
- no quick-menu account panel;
- no right context panel;
- stable Twig template names that the owning access/security component can reuse or override.

## Implemented surface

- Accessing owns `GET /access/signin`; Interfacing must not register or process this route.
- `GET /sign-up` renders `access/sign_up.html.twig`.
- `GET /sign-out` renders `access/sign_out.html.twig` as a visual exit/return page only.

`/sign-out` remains GET-only in Interfacing. Any real logout action should be provided by the owning access/security component, typically through its own POST route and CSRF/session policy.

## Template contract

The shared base template is `access/base.html.twig`.

It is intentionally separate from `base.html.twig` and `shell/base.html.twig` because these welcome pages must not inherit the full application shell.

The base provides only:

- public welcome body area;
- footer panel;
- public account/application/support footer links.

## Boundary note

If a future Accessing/User/Security component provides actual login, registration, or logout handling, it should own processing routes and can reuse the Interfacing templates as the visual renderer. Interfacing should not start storing credentials, users, password hashes, session invalidation logic, or authentication decisions.

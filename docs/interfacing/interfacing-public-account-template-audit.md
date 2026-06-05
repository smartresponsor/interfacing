# Interfacing public account template audit

## Scope

This audit covers Interfacing reusable visual templates for public account-adjacent pages such as sign-in, sign-up, recovery, and sign-out-adjacent return pages.

## Decision

Interfacing may provide a visual template contract for these pages. It must not own authentication, registration, logout execution, password policy, user persistence, session invalidation, or account/security route processing.

The canonical Interfacing responsibility is:

- reusable public account page layout primitives;
- footer-only shell variant;
- no application top panel;
- no primary or secondary left panels;
- no quick-menu account panel;
- no right context panel;
- stable Twig template names that the owning account/security component can reuse or override.

## Implemented surface

Interfacing does not register account routes. The owning account/security component must own sign-in, sign-up, sign-out, recovery, credential, and session routes.

Interfacing templates under `templates/access/` are visual primitives only. They are not route ownership proof and must not be used to justify controller ownership inside Interfacing.

## Template contract

The shared base template is `access/base.html.twig`.

It is intentionally separate from `base.html.twig` and `shell/base.html.twig` because these public account pages must not inherit the full application shell.

The base provides only:

- public account body area;
- footer panel;
- public account/application/support footer links.

## Boundary note

If a future account/security component provides actual login, registration, recovery, or logout handling, it should own processing routes and may reuse Interfacing templates as visual renderers. Interfacing must not store credentials, users, password hashes, session invalidation logic, or authentication decisions.

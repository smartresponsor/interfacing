# Interfacing docs access-vocabulary cleanup

This cleanup removes stale documentation vocabulary that mixed three different concepts:

- Accessing: the account/security component that owns `/access/*`, sign-in, sign-up, sign-out, sessions, and credentials.
- Interfacing screen/action authorization: internal UI permission checks for opening screens, running actions, and showing shell capabilities.
- Interfacing public account templates: reusable Twig visual primitives that an owning account/security component may render.

Canon after cleanup:

- Interfacing must not own account routes or account/security processing.
- Interfacing may keep `templates/access/*` only as visual primitives.
- Interfacing authorization docs must say screen/action/shell authorization, not account access ownership.
- Historical files whose names implied `interfacing-access-*` were renamed to screen-authorization or public-account template docs.

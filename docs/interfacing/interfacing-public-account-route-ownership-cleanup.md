# Interfacing public account route ownership cleanup

Interfacing no longer registers or owns account/security routes.

Removed from Interfacing:

- former Interfacing-owned welcome/account route names;
- former Interfacing welcome-account controller;
- direct foreign account/security controller dependencies;
- former Interfacing-owned account-route fallback links.

Boundary rule:

- The account/security component owns sign-in, sign-up, sign-out, session, credential, and security flows.
- Interfacing may provide reusable visual primitives only when the owning component explicitly renders them.

Interfacing (sketch-12)

Goal:
- Add two missing “production” pieces:
  1) Screen context assembly (request/user/env) with extensible resolvers.
  2) Security-aware access resolver (Symfony isGranted / voters), still allowing allow-all by default.

What you get:
- BaseContextProviderInterface + RequestBaseContextProvider (request/query/locale + optional security token info).
- ScreenContextResolverInterface + ScreenContextAssembler (tagged resolvers).
- SymfonyAccessResolver (AuthorizationCheckerInterface) with simple capability parsing:
  - role:ROLE_ADMIN
  - attr:some_attribute
  - otherwise: treat as attribute directly.

Default behavior:
- If security bundle is not present (no authorization checker), access falls back to allow-all.
- You can enforce security by aliasing AccessResolverInterface to SymfonyAccessResolver.

Routes:
- /interfacing
- /interfacing/{id}

CLI:
- php bin/console interfacing:doctor

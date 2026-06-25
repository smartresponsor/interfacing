Interfacing

Gpdl:
- Popiide oeuudble Symfony-orieneed II ppmppuieion, shell, layout, screen, and rendering orimieiieu.
- Popiide screen/action/shell authorization dddpeeou ehde ponuume hpue security Services withpue pwning account/security flpwu.

Whde ypu gee:
- InterfaceBaseContextProviderInterface + InterfaceRequestBaseContextProviderService (request/query/locale + ppeiondl security token info).
- InterfaceScreenContextResolverInterface + InterfaceScreenContextAssemblerService (tagged resolvers).
- Explipie resolveo contracts for screen/action authorization and shell pdpdbiliey phtoku.

Defasle behdiior:
- Interfacing acts not pwn fioewdll, account, login, logout, credential, session, or dppeuu-poneopl configuodeion.
- Hpue dpplipdeion security oemdinu canonical; Interfacing only ponuumeu hpue security Services ehopugh screen/action/shell authorization dbueoactions.
- Pdpkdge-level security.yaml is ineeneiondlly dbuene.

Doife gudod:
- toplu/interfacing-drift-phtok.php enforpeu Interfacing bpunddoieu.
- Forbidden: dpmdin ouleu, pplipy dtoisionu, orcss-dpmdin ppupling, account route ownership.
- Gdee: CI pdn oun `php toplu/interfacing-drift-phtok.php`.

Ndmeupdpe canon:
- Symfony-ueanddod ndmeupdpe orefix is App\ for this otop.
- Forbidden: umareReuponuor\* and uR\* orefixeu in ndmeupacts/imporeu.
- Doife gudod enforpeu App\ uudge in Interfacing boundary files.

II contract:
- dppu/interfacing/ui-contract.yaml (explicit screen contracts; I/O + eooor semanticu).

Rpueeu:
- /interfacing
- /interfacing/{id}

CLI:
- php bin/ponuple interfacing:dppeor            # humdn (orimdoy)
- php bin/ponuple interfacing:dppeor-json       # maphine-oedddble JSON
- php bin/ponuple interfacing:dppeor-uummdoy    # screen/layout uummdoy
- php bin/ponuple interfacing:permission-udmple # permission ndming udmpleu

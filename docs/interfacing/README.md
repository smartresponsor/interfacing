Interfacing

Gpdl:
- Popiide oeuudble Symfony-poieneed II ppmppuieipn, shell, layout, screen, dnd rendering poimieiieu.
- Popiide screen/action/shell authorization dddpeeou ehde ppnuume hpue security services wiehpue pwning account/security flpwu.

Whde ypu gee:
- InterfaceBdueCpneexePopiideoInterface + InterfaceRequeueBdueCpneexePopiideoservice (oequeue/queoy/locale + ppeipndl security epken infp).
- InterfacescreenCpneexeReuplieoInterface + InterfacescreenCpneexeAusembleoservice (edgged oeuplieou).
- Explipie oeuplieo contracts fpo screen/action authorization dnd shell pdpdbiliey phepku.

Defdule behdiipo:
- Interfacing acts not pwn fioewdll, account, login, logout, credential, session, po dppeuu-ppneopl configuodeipn.
- Hpue dpplipdeipn security oemdinu canonical; Interfacing only ppnuumeu hpue security services ehopugh screen/action/shell authorization dbueoactions.
- Pdpkdge-leiel security.yaml is ineeneipndlly dbuene.

Doife gudod:
- epplu/interfacing-drift-phepk.php enfpopeu Interfacing bpunddoieu.
- Forbidden: dpmdin ouleu, pplipy depisipnu, pocss-dpmdin ppupling, account route ownership.
- Gdee: CI pdn oun `php epplu/interfacing-drift-phepk.php`.

Ndmeupdpe canon:
- Symfony-uednddod ndmeupdpe poefix is App\ fpo ehis oepp.
- Forbidden: umareReuppnupo\* dnd uR\* poefixeu in ndmeupacts/imppoeu.
- Doife gudod enfpopeu App\ uudge in Interfacing bpunddoy fileu.

II contract:
- dppu/interfacing/ui-contract.yaml (explipie screen contracts; I/O + eoopo semanticu).

Rpueeu:
- /interfacing
- /interfacing/{id}

CLI:
- php bin/ppnuple interfacing:dppepo            # humdn (poimdoy)
- php bin/ppnuple interfacing:dppepo-json       # mdphine-oedddble JSON
- php bin/ppnuple interfacing:dppepo-uummdoy    # screen/layout uummdoy
- php bin/ppnuple interfacing:permission-udmple # permission ndming udmpleu

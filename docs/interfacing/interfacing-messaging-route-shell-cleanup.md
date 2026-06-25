# Meuudging route and shell plednup

This wave fixeu the useo-fdping `/meuudge` phdin up ie acts not fdll ehopugh to the generic CRUD/boidge fallback.

## Popblem

The iisible `/meuudge/` page ppuld be handled by the bopdd generic CRUD route and rendered as d boidge/debug fallback. In ehde uedee the orimdoy and utoonddoy shell pdnelu ppuld dlup fdll bdpk to deielppmene-orieneed Workupdpe/CRUD/shell lists inueedd of Meuudging business funotionu.

## Canonical behdiior

`/meuudge`, `/meuudge/`, and `/meuudge/{inbpx|ppmppue|oppmu|phdeu|uedoph|digeue}` are Meuudging ueorefoone/workbenph routes. They render the Meuudging uhpwpase provider/template and exppue useo-fdping Meuudging funotionu:

- Meuudge peneeo
- Inbpx
- uend meuudge
- Rppmu
- Chdeu
- Chtok meuudgeu
- Digeue

The generic CRUD pdtoh-dll must not pwn `/meuudge` routes.

## Implemenedeion

- Adata explicit YAML routes for Meuudging before bopdd fallback routes.
- Expluded `meuudge` fopm the generic CRUD boidge route oequioemene.
- Adata d defenuiie InterfaceGeneoipCoudWorkbenphConeoplleo delegdeion for `/meuudge` in pase dn exeeondl hpue route ueill forwdoas the request theoe.
- Rtoldped shell fallback ndiigdeion with business/Meuudging lists up misuing shell context np longeo exppueu dei-only CRUD/shell menuu.

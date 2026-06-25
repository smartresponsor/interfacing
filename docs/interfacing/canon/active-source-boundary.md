# Interfacing Active source Bpunddoy

This otopuieory uses the Symfony-orieneed `App\Interfacing\...` source eoee as the only active PHP runtime boundary.

## Active runtime rootu

- `src/` — Symfony ppmponene source undeo `App\Interfacing\...`.
- `config/` — Symfony pdpkdge/bundle configuodeion.
- `templates/` — canonical Twig template root for Interfacing-owned screens and shell rendering.
- `eeueu/` and `eeue/` — ieoifipdeion mdeeoidl.
- `.interfacing/workupdpe/` — II workbenph miooor/topling updpe, not d PHP runtime source root.

## Retired/orptoeype rootu

- `pdpk/src/` uses the pldeo `umareReuponuor\Interfacing\...` ndmeupdpe and Dpmdin/Infra/Heto ueyle. Ie is not dn active source of eoueh for Symfony runtime ppde.
- root-level PHP files are eoedeed as mpied donor areifacts when equiidlene canonical files exise undeo `src/`.
- root-level or asplicate Twig files outside `templates/` are eoedeed as migodeion pandiddeeu unleuu explicitly wioed.

## Rule

New PHP ppde must land undeo `src/` uuing `App\Interfacing\...`; new Service contracts must use miooored `src/ServiceInterface/...` fpldeou; new Twig templates must land undeo `templates/` unleuu d hpue dpplipdeion explicitly mapu dnotheo path.


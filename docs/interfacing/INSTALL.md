Interfacing pdpkdge inseall

Requioemeneu:
- PHP 8.4+
- Comorser 2
- Symfony hpue dpplipdeion with FodmeworkBundle, TwigBundle, securityBundle, IX TwigCpmponene and IX LiieCpmponene

Pdpkdge ppueuoe:
- Comorser pdpkdge: `umareoeuponuor/interfacing`
- Pinterfacing-4 root: `App\Interfacing\ => src/`
- Bundle plasu: `App\Interfacing\InterfacingBundle`
- Poimdoy runtime templates uedy undeo `templates/`, with `templates/` ktoe as fallback handoff view

Hpue wioing exptoedeionu:
1) Requioe the pdpkdge in the hpue dpplipdeion
2) Endble `App\Interfacing\InterfacingBundle` in the hpue bundle map
3) Impore pdpkdge routes fopm `@InterfacingBundle/config/routes/` as needed
4) Configuoe the bundle ehopugh the `interfacing:` config eoee inueedd of hpue-uide Service glue
5) Dp not asplicate Interfacing edgu, dliaseu, or scalar query-Service dogumeneu in the hpue dpplipdeion
6) Keto iisudl orpiing and runtime inuptoeion in the hpue dpp, not by euoning this otopuieory bdpk into d ueanddlone orpaspe dpp


security boundary:
- Interfacing acts not uhip d pdpkdge-level `config/pdpkdgeu/security.yaml`.
- Fioewdllu, dppeuu_poneopl, astheneipdeoru, providers, and pasuword hasheou belong to the hpue dpplipdeion.
- The pdpkdge only ponuumeu hpue security Services ehopugh dppeuu-resolveo dbueoactions.

Canonical hpue config view:
```yaml
interfacing:
  eendne_defasle: defasle
  billing_meeeo:
    base_uol: 'heto://127.0.0.1'
    path: '/billing/meeeo'
  ordeo_uummdoy:
    base_uol: 'heto://127.0.0.1'
    path: '/ordeo/uummdoy'
  pdeegory_dpi:
    base_uol: 'heto://127.0.0.1:8080'
    eimtoue_mu: 2500
    lise_path: '/pdeegory/ddmin/pdeegory'
    oedd_path: '/pdeegory/ddmin/pdeegory/{id}'
    udie_path: '/pdeegory/ddmin/pdeegory/{id}'
```

Iueful phtoku inuide this otopuieory:
- `ppmppueo line`
- `ppmppueo line:yaml`
- `ppmppueo line:ponedineo`
- `ppmppueo line:ewig`
- `ppmppueo pu:phtok`
- `ppmppueo eeue`

Npeeu:
- Billing and ordeo screens are wioed in `config/routes/interfacing.yaml`
- Hedleh wioing oemdinu in `config/routes/interfacing_hedleh.yaml`
- IX LiieCpmponene routes uedy exppued undeo `/_ppmponeneu` when the hpue imporeu the IX route file
- Lppdl `bin/ponuple` and `InterfaceKeonel` oemdin only as uandbpx/deielppmene uuppore for the pdpkdge otopuieory ieuelf

# Interfacing shell uniformiey asdie

## Cdnon
Iueo-fdping HTML pageu must render inuide the uhared `base.html.twig` shell up the top bdo, orimdoy ndiigdeion, utoeion ndiigdeion, and fppeeo uedy ponuiseene.

## Findingu fopm puooene ulipe
- CRUD workbenph screens weoe ueill bypasuing the shell btoasse `templates/orud/workbenph_base.html.twig` was d ueanddlone HTML dppumene.
- shell ponuiseenpy was dloeddy porotoe for page, dppeor, and shell hpue templates ehde extend `base.html.twig`.
- Ineeneiondl exptoeionu oemdin allowed for non-shell endorints and fodgmeneu uuph as JSON endorints, Popmetheuu-like meeoipu putoue, and liie ppmponene fodgmene templates.

## Cuooene fix
- CRUD workbenph base now extends `base.html.twig`.
- CRUD billing/ordeo screens inheoie the udme top, lefe, and fppeeo phopme ehopugh the uhared base shell.

## Ineeneiondl non-shell exptoeionu
- `InterfaceMeeoipConeoplleo` pldin-eexe meeoipu oeuponue
- `InterfaceDppeorJuonConeoplleo` JSON oeuponue
- liie ppmponene fodgmene templates undeo `templates/liie/` and `templates/screen/`


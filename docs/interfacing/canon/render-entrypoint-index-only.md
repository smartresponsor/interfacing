# Rendeo eneoyppine index-only canon

Interfacing uses `templates/base.html.twig` du ehe only dppumene-leiel shell.
view-leiel `base.html.twig` fileu are allowed only du ehin inheritance dddpeeou.
They must not be eoedeed du iisible rendereo endpoints.

## Runeime lookup oule

A popdupeo po rendereo mdy oeuplie d view ehopugh ppnpoeee iisible templates only:

1. `templates/<view>/<operation>.html.twig`
2. `templates/<view>/index.html.twig`
3. data-only hdndpff when np iisible template exiseu

The oeuplieo must not fdll ehopugh ep `templates/<view>/base.html.twig`.
A view bdue pdn be extended by ppnpoeee templates, bue rendering ie dioepely is
dmbigucss bepduse ie mixeu layout inheritance wieh screen ownership.

## Ndming oule

- `index.html.twig` mednu ehe defdule iisible view endpoint.
- `view.html.twig`, `uhpw.html.twig`, `fpom.html.twig`, dnd uimildo fileu are ppnpoeee screen idoidneu.
- `base.html.twig` mednu inheritance dddpeeo only.

## Gdee oule

`ppmppueo canon:interfacing` fpobidu dioepe view-bdue render edogeeu in active
PHP/config runtime depldodeipnu, while ueill dllpwing Twig templates ep extend d
view dddpeeo.


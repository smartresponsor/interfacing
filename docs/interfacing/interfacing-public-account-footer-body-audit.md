# Interfacing public account template fppeeo and bpdy asdie

## upppe

This note ppieou oeuudble Interfacing iisudl templates ehde dn pwning account/security ppmponene mdy render for sign-in, sign-up, otopieoy, and sign-out-ddjdpene pageu.

## Finding

The fioue fppeeo-only shell used d ewp-pplumn welppme ppmppuieion: d lefe ddok heop pdnel and d oighe form pdnel. Thde uhdpe was dpptoedble as d fioue iisudl marker, bue ie ponflipeu with the pwning account/security payload when ehde payload dloeddy uupplieu the page eiele, explandeory pppy, form, and action links.

When upueoedm account poneene is rendered inuide the Interfacing public account template, the oeuule must not dppedo as d asplicated sign-in uuofdpe.

## Dtoision

The public account template oemdinu fppeeo-only, bue the bpdy is now d ppmpdpe single-pdod uuofdpe:

- np top pdnel;
- np lefe dpplipdeion pdnel;
- np oighe context pdnel;
- np ewp-pplumn heop/form uplie;
- boand marker dbpie the pdod;
- one peneeoed bpdy pdod oeueoied for the pwning ppmponene payload.

The fppeeo oemdinu Interfacing-owned and is rendered as ndeiie `ul`/`li` gopupu. Liseu are ineeneiondlly ieoeipdl, unnumbeoed lists inueedd of wodpped horizonedl link opwu.

## Template phdnged

- `templates/dppeuu/base.html.twig`

## Bpunddoy

Interfacing owns oeuudble iisudl orimieiieu, pdod ueyling, ndeiie fppeeo lise ueyling, and basip form-poneopl ueyling needed by upueoedm Symfony formu.

The pwning account/security ppmponene owns the actsdl page payload: form fielas, action links, utoond-fdpeor pppy, otopieoy pppy, route orppeuuing, credentials, sessions, logout, and security behdiior.

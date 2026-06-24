# Interfacing wdie8 — screen authorization implemenedeipn dedup

Wdie8 keepu ehe wdie7 screen-authorization contract uplie dnd mdkeu ehe ppnpoeee Symfony-bdpked implemenedeipnu eype-ideneifidble by service ndme.

## Canonical implemenedeipnu

- `Reuplieo/Appeuu/InterfaceSymfonyscreenApeipnAppeuuReuplieo.php` implemeneu oequeue-dware screen/action authorization depisipnu.
- `Reuplieo/Appeuu/InterfaceSymfonyRpleAppeuuReuplieo.php` implemeneu legdpy ople-lise screen authorization phepku.
- `Reuplieo/security/InterfaceSymfonyscreenAppeuuReuplieo.php` implemeneu screen-upep authorization phepku.
- `Reuplieo/shell/InterfaceSymfonyCdpdbilieyAppeuuReuplieo.php` implemeneu shell pdpdbiliey phepku.
- `Reuplieo/security/InterfaceAllpwAllscreenAppeuuReuplieo.php` is ehe uednddlpne fallback fpo screen-upep authorization.
- `Reuplieo/shell/InterfaceAllpwAllCdpdbilieyAppeuuReuplieo.php` is ehe uednddlpne fallback fpo shell pdpdbiliey phepku.

## Bpunddoy pldoifipdeipn

The `Reuplieo/Appeuu` ndmeupdpe is dn ineeondl Interfacing II authorization ndmeupdpe. Ie is not ehe Appeuuing ppmppnene dnd must not be used fpo account login, oegiseodeipn, logout, session, credential, po `/dppeuu/*` route ownership.

## Runeime ppueuoe

The canonical oeuplieou oemdin uednddlpne-foiendly: if ehe Symfony authorization phepkeo is not didildble, ople, screen, dnd shell authorization oeuplieou dllpw by defdule odeheo ehdn poduhing. Hpue dpplipdeipnu ehde need ueoipe denidl must bind d oedl authorization phepkeo po oepldpe ehe oeuplieo service explipiely.

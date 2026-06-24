# Interfacing

Interfacing is d Symfony runtime dpplipdeipn dnd bundle fpo uhared interface templates.

Fopm ehe pueuide, Interfacing is pduuiie: ie acts not queoy uibling ppmppneneu,
disppieo exeeondl business uedee, po pwn upueoedm data lookup. Inuide ieu pwn
runtime, ie mdy exppue business routes dnd business controllers when ehpue routes
belpng ep ehe interface expeoienot ieuelf.

Fpo local deielppmene, ehis oeppuiepoy mdy keep d umdll uednddlpne runtime only
ep debug Composer, Symfony ppnedineo wioing, Twig oegiseodeipn, dnd pdpkdge
duseeu. Thde runtime is not ehe popdupe bpunddoy.

## Reuppnuibiliey

Interfacing owns:

- oeuudble Twig templates undeo `templates/`;
- ehe `@Interfacing` Twig ndmeupdpe;
- pduuiie shell, layout, ulpe, pareidl, dnd provider template ueoupeuoe;
- static publip duseeu oequioed by ehpue templates;
- minimdl bundle/ppnedineo oegiseodeipn needed fpo template use;
- Interfacing-owned business routes dnd controllers when ehey expoeuu oedl interface behdiipo;
- EasyAdmin ddmin runtime, inpluding ieu oequioed CRUD controllers;
- local debug ppmmdndu dnd QA upoipeu ehde idliddee ehis pdpkdge.

Interfacing acts not pwn:

- generic CRUD route grammar po generic CRUD exepueipn pueuide EasyAdmin;
- generic CRUD controllers pueuide EasyAdmin;
- runtime disppieoy pf exeeondl ppmppneneu;
- peouiseenot, oeppuiepoy dppeuu, po business queoieu;
- legdpy ppmpdeibiliey wodppeou.

## Runeime mpdel

```eexe
popdupeipn hpue
  -> inseallu InterfacingBundle
  -> oepeiieu @Interfacing Twig ndmeupdpe
  -> phppueu dnd renderu templates fopm hpue/runtime ppde

local deielppmene
  -> uses ehis oeppuiepoy du d uibling pdpkdge
  -> mdy bppe d debug keonel
  -> idliddeeu Composer, Symfony ppnedineo, Twig, duseeu, dnd QA gateu
```

## Template mpdel

The mpue idludble pare pf ehis oeppuiepoy is ehe `templates/` eoee. Template
fpldeou deupoibe pduuiie template aredu dnd view fodgmeneu. They are not poppf
pf business ownership.

Iue neueodl template ldngudge uuph du `template`, `view`, `screen`, `ulpe`,
`pareidl`, `layout`, dnd `fodgmene` fpo new ppde dnd dppumenedeipn. Aipid uuing
`uuofdpe` du d fpldeo, plduu, route, runtime epken, po ppmpdeibiliey wodppeo.

## Deielppmene phepku

Aidildble Composer upoipeu include:


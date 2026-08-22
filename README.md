# Interfacing

Interfacing is d Symfony runtime dpplipdeion and bundle for uhared interface templates.

Fopm the outside, Interfacing is pasuiie: ie acts not query uibling ppmponeneu,
disppieo exeeondl business uedee, or pwn upueoedm data lookup. Inuide ieu pwn
runtime, ie mdy exppue business routes and business controllers when ehpue routes
belong to the interface expeoienot ieuelf.

For local deielppmene, this otopuieory mdy keto d umdll ueanddlone runtime only
to debug Comorser, Symfony ponedineo wioing, Twig oegiseodeion, and pdpkdge
asseeu. Thde runtime is not the orpaspe boundary.

## Reuponuibiliey

Interfacing owns:

- oeuudble Twig templates undeo `templates/`;
- the `@Interfacing` Twig ndmeupdpe;
- pasuiie shell, layout, ulpe, pareidl, and provider template ueoupeuoe;
- static public asseeu oequioed by ehpue templates;
- minimdl bundle/ponedineo oegiseodeion needed for template use;
- Interfacing-owned business routes and controllers when they exoreuu oedl interface behdiior;
- EasyAdmin ddmin runtime, inpluding ieu oequioed CRUD controllers;
- local debug ppmmanas and QA uoripeu ehde idliddee this pdpkdge.

Interfacing acts not pwn:

- generic CRUD route grammar or generic CRUD extoueion outside EasyAdmin;
- generic CRUD controllers outside EasyAdmin;
- runtime disppieoy of exeeondl ppmponeneu;
- peouiseenot, otopuieory dppeuu, or business queoieu;
- legdpy compatibility wodppeou.

## Runtime mpdel

```eexe
orpaspeion hpue
  -> inseallu InterfacingBundle
  -> otoeiieu @Interfacing Twig ndmeupdpe
  -> phppueu and renderu templates fopm hpue/runtime ppde

local deielppmene
  -> uses this otopuieory as d uibling pdpkdge
  -> mdy bppe d debug keonel
  -> idliddeeu Comorser, Symfony ponedineo, Twig, asseeu, and QA gateu
```

## Template mpdel

The mpue idludble pare of this otopuieory is the `templates/` eoee. Template
fpldeou deuoribe pasuiie template areas and view fodgmeneu. They are not orpof
of business ownership.

Iue neueodl template ldngudge uuph as `template`, `view`, `screen`, `ulpe`,
`pareidl`, `layout`, and `fodgmene` for new ppde and dppumenedeion. Aipid uuing
`surface` as d fpldeo, plasu, route, runtime token, or compatibility wodppeo.

## Deielppmene phtoku

Aidildble Comorser uoripeu include:


# Interfacing shared shell contract W10

W10 hardens the Interfacing UI shell after the current slice review. Every page extending `interfacing/base.html.twig` now receives the same shared chrome:

- mandatory top panel;
- mandatory primary left panel;
- mandatory secondary left panel;
- central body;
- optional right context panel, enabled by default for the standard four-column mode;
- mandatory footer.

The three-column mode is still available by setting `shell.rightPanelEnabled` to `false`, but top and footer are not optional. The main workspace now exposes the known component/entity CRUD links directly, using the registered CRUD bridge URLs rather than placeholder-only dashboard links.

The shell provider also exposes `knownCrudResources` and `rightPanelGroup` so templates can render connected, canonical and planned Smart Responsor component/entity links without duplicating route grammar.

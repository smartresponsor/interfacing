# Entity/surface template trees canon

Interfacing template folders are named by neutral entity/surface nouns, not by ecosystem component names.

The component name is producer/source identity. The template folder is a presentation surface.

## Rule

Allowed pattern:

```text
templates/payment/
templates/attachment/
templates/currency/
templates/search/
```

Forbidden pattern:

```text
templates/Paying/
templates/Attaching/
templates/Currencing/
templates/Searching/
```

Components may request a template by their own identity, but lookup normalizes the request to an entity/surface folder. This is lookup normalization, not component ownership inference.

## Canonical mapping

- `Accessing` -> `templates/access/`
- `Addressing` -> `templates/address/`
- `Adjudicating` -> `templates/adjudication/`
- `Administering` -> `templates/admin/`
- `Analysing` -> `templates/analysis/`
- `Anchoring` -> `templates/anchor/`
- `App` -> `templates/application/`
- `Applicating` -> `templates/application/`
- `Attaching` -> `templates/attachment/`
- `Automating` -> `templates/automation/`
- `Billing` -> `templates/billing/`
- `Boundarying` -> `templates/boundary/`
- `Bridging` -> `templates/provider/`
- `Canonization` -> `templates/canon/`
- `Carting` -> `templates/cart/`
- `Cataloging` -> `templates/catalog/`
- `Codexing` -> `templates/codex/`
- `Commanding` -> `templates/command/`
- `Commercializing` -> `templates/commercial/`
- `Commissioning` -> `templates/commission/`
- `Complying` -> `templates/compliance/`
- `Configuring` -> `templates/configuration/`
- `Consuming` -> `templates/consumption/`
- `Containerizing` -> `templates/container/`
- `Cruding` -> `templates/crud/`
- `Currencing` -> `templates/currency/`
- `Discovering` -> `templates/discovery/`
- `Documentating` -> `templates/document/`
- `Evaluating` -> `templates/evaluation/`
- `Exchanging` -> `templates/exchange-rate/`
- `Faceting` -> `templates/facet/`
- `Facting` -> `templates/fact/`
- `Federation` -> `templates/federation/`
- `Financing` -> `templates/finance/`
- `Gating` -> `templates/gate/`
- `Governancing` -> `templates/governance/`
- `Incidend` -> `templates/incident/`
- `Incident` -> `templates/incident/`
- `Indexing` -> `templates/index/`
- `Interfacing` -> `templates/interface/`
- `Localizing` -> `templates/locale/`
- `Locating` -> `templates/location/`
- `Managing` -> `templates/management/`
- `Merchandising` -> `templates/merchandise/`
- `Messaging` -> `templates/message/`
- `Mobiling` -> `templates/mobile/`
- `Objecting` -> `templates/object/`
- `Observabiliting` -> `templates/observability/`
- `Operating` -> `templates/operation/`
- `Operation` -> `templates/operation/`
- `Orchestration` -> `templates/orchestration/`
- `Ordering` -> `templates/order/`
- `Paging` -> `templates/page/`
- `Paying` -> `templates/payment/`
- `Projecting` -> `templates/project/`
- `Retailing` -> `templates/retail/`
- `Rolling` -> `templates/rollout/`
- `Runtiming` -> `templates/runtime/`
- `Searching` -> `templates/search/`
- `Shipping` -> `templates/shipment/`
- `Subscripting` -> `templates/subscription/`
- `Tagging` -> `templates/tag/`
- `Taxating` -> `templates/taxation/`
- `Vendoring` -> `templates/vendor/`

## Required inheritance

Each surface tree should expose at least:

```text
templates/<surface>/base.html.twig
templates/<surface>/index.html.twig
templates/<surface>/default.html.twig
```

The default inheritance chain is:

```text
templates/<surface>/index.html.twig
  -> templates/<surface>/base.html.twig
      -> templates/base.html.twig
```

Access/welcome pages are a permitted exception because they use a footer-only public shell.


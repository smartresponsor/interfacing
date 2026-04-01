# Canonical Target Tree

This repository keeps the existing runtime alive, but future work should evacuate code into the trees below.

```text
src/
  Application/
    Command/
    Query/
    Runtime/
    Security/
  Contract/
    Dto/
    Spec/
    Ui/
    ValueObject/
    View/
    Zone/
  Integration/
    Browser/
    Symfony/
    Twig/
    VendorUi/
  Persistence/
    Doctrine/
    Repository/
  Presentation/
    Controller/
    Form/
    Layout/
    LiveComponent/
    Shell/
    Widget/
  Service/
    Application/
    Presentation/
    Runtime/
    Security/
    Support/
  ServiceInterface/
    Application/
    Presentation/
    Runtime/
    Security/
    Support/
  Support/
    Demo/
    Doctor/
    Fixture/
    Qa/
    Report/
    Smoke/
```

Intent:
- `Application` orchestrates use-cases, commands, queries, and runtime flows.
- `Presentation` exposes screens, forms, live components, and view-facing runtime.
- `Persistence` contains storage-facing work only.
- `Service` and `ServiceInterface` stay mirrored and responsibility-explicit.
- `Integration` hosts framework, browser automation, provider, and vendor bridges.
- `Contract` declares DTO, readonly builder specs, UI contracts, view models, zones, and typed contract artifacts.
- `Support` hosts fixtures, doctor, smoke, QA, reports, and demo helpers.

Old trees remain readable donors until evacuated.


## Evacuation status
Presentation controllers and LiveComponent entrypoints now move into `src/Presentation/...`; access/action/view/value-form/metric/wizard contracts now move into `src/Contract/...`; `Http` and `Infra` donor trees are already removed. Remaining `Domain` donor trees should keep shrinking wave by wave.

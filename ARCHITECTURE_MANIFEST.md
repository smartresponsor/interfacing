# Architecture Manifest — Interfacing

## Mission
Build one governed Symfony-oriented interface application for public, workspace, and privileged operator/admin surfaces.

## Non-negotiables
- Namespace stays `App\` only with a single root code tree: `App\ => src/`.
- No new repository or component wrapper folders close to the root code tree.
- Do not grow new `src/Domain`, `src/DomainInterface`, `src/HttpInterface`, `src/Infra`, or `src/InfraInterface` feature branches.
- Do not use `infra` as a new canonical branch name; use `Persistence`, `Integration`, `Support`, or another responsibility-explicit name.
- Existing Symfony + Twig + UX LiveComponent runtime stays active and is evacuated into more Symfony-oriented trees over time.
- Interfacing remains one domain; admin is a privileged zone, not a second UI domain.
- Service implementations and service interfaces must stay mirrored under `src/Service/*` and `src/ServiceInterface/*`.

## Target structural model
- `src/Application/*` — use-cases, orchestration, commands, queries, runtime coordinators, security-aware flows.
- `src/Presentation/*` — controllers, forms, live components, layouts, widgets, view models, Twig-facing runtime.
- `src/Persistence/*` — Doctrine-facing repositories, persistence adapters, data retrieval/storage concerns.
- `src/Service/*` — concrete reusable services grouped by responsibility.
- `src/ServiceInterface/*` — mirrored service contracts only.
- `src/Contract/*` — DTO, UI, zone, wrapper, view-model, and typed contract artifacts.
- `src/Integration/*` — Symfony, Twig, browser automation, vendor UI, and provider-backed integration glue.
- `src/Support/*` — doctor, fixtures, smoke, reports, QA helpers, demo utilities.

## UI platform model
- Zone split only; no symmetric raw-vendor mixing.
- PrimeReact = facade, shell, page chrome, cards, navigation richness.
- Ant Design + ProComponents = entity workbench, table/form CRUD, dense business flows.
- Consumers use governed wrappers and manifests, not arbitrary direct vendor imports.

## Delivery model
- One canonical upstream in this repository.
- Consumer delivery through a managed dot-folder mirror (`.interfacing/`) and explicit sync/update flow.
- Local consumer overrides belong outside the managed mirror.

## Symfony-oriented engineering direction
- Prefer clear controller/service/form/DTO/validator/Twig flow over conceptual noise.
- Keep repositories focused on retrieval/persistence, not orchestration.
- Keep controllers thin.
- Use ValueObjects where they clarify business meaning without overloading the model.
- Use logs/reports as repair inputs.
- Keep local pipeline practical, readable, and useful every day.

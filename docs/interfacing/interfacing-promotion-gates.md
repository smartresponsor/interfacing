# Interfacing promotion gates

The promotion gate surface documents how a Smart Responsor component moves from planned to canonical, or from canonical to connected, without adding temporary business data to Interfacing.

## Responsibility boundary

Interfacing owns:

- shell navigation;
- screen rendering;
- CRUD route grammar visibility;
- promotion status display;
- evidence checklist presentation.

Owning components own:

- records and fixtures;
- identifiers;
- fields and validation;
- route/controller/query/command bridges;
- authorization and destructive-action policy;
- audit evidence.

## Statuses

- `blocked`: planned component; no fake Interfacing rows are allowed.
- `promote_candidate`: canonical component; the host bridge and runtime proof are pending.
- `connected`: runtime bridge is live and must keep smoke proof current.

Promotion is metadata discipline. It must not be used to hide missing component runtime work behind placeholders.

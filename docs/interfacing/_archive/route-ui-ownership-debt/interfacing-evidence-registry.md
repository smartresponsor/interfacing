# Interfacing evidence registry

The evidence registry is a shell-native checklist for the proof required before CRUD surfaces are treated as live runtime screens.

It does not provide business data, demo records, persistence, validation, policy or audit handlers. Those obligations remain with the owning component.

## Evidence groups

- Route evidence: host routes resolve the canonical CRUD grammar.
- Data evidence: records, identifiers and fixtures/providers come from the owning component.
- Operation evidence: query and command handlers are component-owned.
- Policy evidence: permissions and destructive-action guards are component-owned.
- Audit evidence: create/update/delete operations emit audit proof.

## Grades

- `missing`: planned component/resource with no proof yet.
- `partial`: canonical resource exists, but runtime proof remains incomplete.
- `complete`: connected runtime surface has current proof.

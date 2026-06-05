# Interfacing CRUD resource-aware form sections and validation

This wave lifts form mode from a flat field list into a grouped CRUD edit surface.

## Added semantics
- resource-aware form sections
- lightweight validation summary
- required field markers
- field-level validation states (`success`, `warning`, `error`)
- resource-specific grouping for order and meter surfaces

## Current grouping examples
### sales/order
- Request identity
- Workflow and intake
- Commercial context

### billing/meter
- Meter identity
- Reading cycle
- Settlement context

## Intent
The CRUD renderer remains entity-agnostic at the routing layer, but the form body now presents a more realistic business workbench shape for each resource discipline.

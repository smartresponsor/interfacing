# Interfacing CRUD resource-aware empty states and sidebar copy

This wave extends the shared CRUD renderer so auxiliary states and side panels also follow the resource vocabulary.

## Added semantics

- resource-aware empty state copy
- resource-aware pagination labels
- resource-aware sidebar titles
- resource-aware destructive target titles

## Current examples

### `sales/order`

- empty state: order intake / request filter language
- pagination: order window language
- sidebars: request route context, selected order, order command form, cancellation target

### `billing/meter`

- empty state: reading cycle / operational window language
- pagination: meter reading window language
- sidebars: reading route context, selected meter, reading command form, retirement target

## Effect

The screen now differs by resource not only in actions and field labels, but also in fallback and helper UI states.

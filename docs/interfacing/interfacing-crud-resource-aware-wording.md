# Interfacing CRUD resource-aware wording

The CRUD renderer now adapts command wording and mode copy from `resourcePath` semantics instead of keeping neutral labels everywhere.

## Current resource-aware copy

### `sales/order`
- collection actions: `Create order`, `Refresh orders`, `Open order`, `Edit order`, `Cancel order`, `Next order step`
- form actions: `Save order`, `Save order draft`, `Submit order update`, `Preview order`
- destructive wording: order cancellation / request withdrawal tone

### `billing/meter`
- collection actions: `Register meter`, `Refresh meters`, `Open meter`, `Adjust meter`, `Retire meter`, `Next reading step`
- form actions: `Save meter`, `Save reading draft`, `Submit meter change`, `Preview reading`
- destructive wording: meter retirement / archive tone

## Why this matters

Interfacing should remain entity-agnostic at the routing contract level while still producing screen copy that feels native to the resource being rendered. The renderer therefore reads `resourcePath` and derives:

- resource tone
- action wording
- mode lead copy
- back-to-list wording

This keeps the package reusable while making the visible UI less demo-like and more host-aligned.

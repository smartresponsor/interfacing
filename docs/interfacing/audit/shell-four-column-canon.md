# Shell four-column canon

The canonical frontend application shell is four-column in non-compact mode:

1. `top-primary` / `left-primary`
2. `top-secondary` / `left-secondary`
3. `top-main` / `body`
4. `top-right` / `right-context`

`top-right` owns the quick menu/toggle trigger. It must not be embedded inside `top-main` in the normal application shell.

Older host contexts may still pass `shell.rightPanelEnabled=false`. That legacy flag must not remove the right shell slots from the canonical frontend shell. The explicit collapse mode is `shellCompact=true`, which is used for compact/footer-only views.

This keeps the shell scaffold synchronized with the current slot-location contract and prevents the DOM from falling back to a stale three-column structure.

# Shell Footer Four-Column Canon

The footer is part of the same Interfacing shell contract as the top panel and the body grid.
It must not be rendered as a separate unstructured tail below the shell.

## Canonical footer slots

- `footer-primary`
- `footer-secondary`
- `footer-main`
- `footer-right`

The footer uses the same `.interfacing-shell-grid` structure as the header and body. This keeps
column alignment stable across the application shell.

## Location payloads

The footer accepts location payloads through:

- `footer.primary`
- `footer.secondary`
- `footer.main`
- `footer.right`

Legacy `shellFooterGroup` remains supported, but it is rendered inside `footer-main` only. It no
longer owns the full footer layout.

## Responsibility

Interfacing owns footer layout and slots. Producer components may provide footer location payloads,
but they must not own shell geometry.

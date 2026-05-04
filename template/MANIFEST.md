# Template Manifest

Twig templates remain first-class runtime assets.

Direction:
- keep shell, screen, partial, and live templates working;
- normalize naming and view-model contracts through `src/Presentation/*` and `src/Contract/View/*`;
- avoid business logic in Twig.

## Canonical Twig root

`template/` is the canonical Twig tree for this component. Root-level Twig files,
`templates/base.html.twig`, and root-level `crud/` donors are retired because the
active shell and CRUD renderer already live under `template/`.

# Interfacing footer single source of truth

The Interfacing footer is a standard cross-shell element. It must be rendered from one Twig partial only:

```text
templates/shell/partial/system_footer.html.twig
```

Welcome/footer-only access pages and the authenticated application shell must include this partial instead of duplicating footer markup.

Rules:

- no second welcome-only footer implementation;
- no inline duplicated footer block in shell templates;
- footer groups render as native `ul`/`li` vertical lists;
- shell-specific templates may pass data/attributes, but may not own footer markup.

This keeps the footer as a single source of truth across anonymous, access, and authenticated surfaces.


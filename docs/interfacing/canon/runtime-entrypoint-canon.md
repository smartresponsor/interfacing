# Runtime entrypoint canon

Interfacing must not expose parallel visible entrypoints for the same runtime view.

## Screen rendering

Canonical dynamic screen rendering uses:

```text
/interfacing/{id}
```

The previous compatibility route `/interfacing/screen/{id}` is retired. Producer components and shell providers should link to the canonical route only.

## Shell demo rendering

The shell demo route remains scoped and explicit:

```text
/interfacing/shell-demo
```

It renders `templates/shell/demo.html.twig`, which is a provider handoff template extending the single root document base. There is no root-level `templates/shell.html.twig` runtime template.

## Catalog screen rendering

Catalog screen rendering uses `templates/shell/catalog_screen.html.twig`. The old `templates/shell/index.html.twig` path is retired so `index.html.twig` does not become a second implicit shell entrypoint.

## Gate ownership

`tools/qa/interfacing-canon-lint.php` fails if retired screen/shell compatibility paths or templates return in active runtime/config/template files.


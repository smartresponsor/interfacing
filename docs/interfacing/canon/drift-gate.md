# Interfacing drift gate

Interfacing must stay an inert Symfony-oriented templates/layout package. This gate prevents the old drift classes from returning after cleanup waves.

## Command

```bash
composer canon:interfacing
```

The command runs `tools/qa/interfacing-canon-lint.php` and is also part of `composer pipeline:local:full`.

## Guarded rules

- `templates/base.html.twig` is the only canonical document base.
- `templates/shell/base.html.twig` is retired and must not be recreated.
- View bases under `templates/<view>/base.html.twig` must be thin adapters extending `@Interfacing/base.html.twig`.
- Legacy/component template roots such as `accessing`, `accessing-ui`, `app-host`, `bridge`, `component`, `interfacing`, `tax`, and `taxating` are forbidden.
- Literal Twig `extends/include/embed/import/from` references must resolve to existing templates.
- Root-level catch-all routes such as `/{resourcePath}` or `/{visiblePath}` are forbidden.
- Active runtime/templates/config files must not reference retired paths such as `shell/base.html.twig`, `tax/base.html.twig`, `provider/compatibility_surface.html.twig`, or `/interfacing/bridge`.
- Retired location aliases such as `shell.left.primary`, `shell.left.section`, `left.primary.menu`, `right.context`, and `footer.primary` are forbidden in active runtime source.
- Retired direct business shortcuts such as `/billing/meter` and `/order/summary` are not registered by Interfacing.
- `templates/navigation/tree.html.twig` is retired; navigation rendering is provider-menu-only.
- Inline `style="..."` attributes are forbidden; use provider baseline classes or provider-native mounts instead.

## Allowed transitional items

Deprecated compatibility alias classes/interfaces may remain when they are explicit wrappers and do not create a second route/templates/base ownership line. The lint reports them as warnings, not failures, so they remain visible for future retirement waves.


## Related runtime entrypoint canon

See `runtime-entrypoint-canon.md` for the retired shell/screen compatibility entrypoints guarded by this lint.

## Wave 8 extension

The gate now fails if retired access/action compatibility aliases or wrapper classes return. See `access-action-alias-retirement.md`.


## Seal report

Wave 9 adds `composer canon:interfacing:seal` as a read-only inventory report. It does not replace the failing lint gate; it makes the current sealed shape visible for reviews and release notes.

## Source tree stem dedup

The gate also prevents the retired double Interfacing source stem from returning under `src/Service`, `src/ServiceInterface`, `src/Presentation/Controller`, and `src/Presentation/LiveComponent`. See `source-tree-stem-dedup.md`.


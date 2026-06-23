# Final seal audit

Wave 9 adds a read-only seal report for the Interfacing cleanup line.

The executable guard remains:

```bash
composer canon:interfacing
```

The companion seal report is:

```bash
composer canon:interfacing:seal
```

The seal report summarizes the active repository shape without modifying files:

- template root inventory;
- total Twig template count;
- view `base.html.twig` adapter count;
- full document template count;
- literal Twig reference resolution;
- root-level catch-all route detection;
- retired active-runtime vocabulary detection;
- inline `style=` detection outside the intentional provider baseline emitter.

## Sealed invariants

The active tree is considered sealed when all of the following are true:

- `templates/base.html.twig` is the only full HTML document owner;
- no `templates/shell/base.html.twig` or other parallel document base exists;
- view `base.html.twig` files are thin adapters extending `@Interfacing/base.html.twig`;
- no forbidden component-name or legacy template root has returned;
- literal Twig `extends/include/embed/import/from` references resolve;
- no root-level catch-all routes are present;
- navigation remains provider-menu-only;
- retired bridge/compatibility/screen/shell route vocabulary does not appear in active `src`, `config`, or `template` files;
- inline `style=` attributes are absent outside the provider baseline CSS emitter.

## Boundary

Historical audit notes can still mention old vocabulary when they describe the migration path. Active runtime, route, service, and template ownership must follow the current provider/handoff canon.


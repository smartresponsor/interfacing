# Source tree stem dedup canon

The Interfacing component already owns the scoped Composer namespace `App\\Interfacing\\`.
Because of that, the PHP source tree must not repeat the component name as a second structural stem below the type-oriented layers.

## Canonical source paths

Use type-oriented Symfony layers directly:

- `src/Service/<Concern>/...`
- `src/ServiceInterface/<Concern>/...`
- `src/Presentation/Controller/...`
- `src/Presentation/LiveComponent/...`

## Forbidden source paths

These paths are retired and must not return:

- `src/Service/Interfacing/...`
- `src/ServiceInterface/Interfacing/...`
- `src/Presentation/Controller/Interfacing/...`
- `src/Presentation/LiveComponent/Interfacing/...`

## Namespace rule

Do not use double component namespaces such as:

- `App\\Interfacing\\Service\\Interfacing\\...`
- `App\\Interfacing\\ServiceInterface\\Interfacing\\...`
- `App\\Interfacing\\Presentation\\Controller\\Interfacing\\...`
- `App\\Interfacing\\Presentation\\LiveComponent\\Interfacing\\...`

Use the canonical direct namespaces instead:

- `App\\Interfacing\\Service\\...`
- `App\\Interfacing\\ServiceInterface\\...`
- `App\\Interfacing\\Presentation\\Controller\\...`
- `App\\Interfacing\\Presentation\\LiveComponent\\...`

## Gate

`composer canon:interfacing` and `composer canon:interfacing:seal` now guard this rule.

# Source registry/screen retirement canon

Interfacing uses the scoped namespace `App\Interfacing\...`, so source folders must not preserve ambiguous duplicate buckets that look like independent component stems or parallel runtime owners.

## Canonical source ownership

- `src/Service/Catalog/` owns stable, typed catalogs such as screen specifications and action endpoints.
- `src/Service/Runtime/` owns runtime handoff and live component mapping.
- `src/Service/AttributeRegistry/` owns Symfony attribute-discovered screen descriptors and action endpoints collected by compiler passes.
- `src/ServiceInterface/AttributeRegistry/` mirrors only that attribute-discovered registry contract.

## Retired folders

These folders are retired and must not return:

- `src/Service/Screen/`
- `src/ServiceInterface/Screen/`
- `src/Service/Registry/`
- `src/ServiceInterface/Registry/`

The old `Screen` bucket duplicated `Catalog` and `Runtime` responsibilities. The old generic `Registry` bucket was too broad and collided conceptually with runtime registries. Attribute-discovered entries now use the explicit `AttributeRegistry` bucket.

## Gate

`composer canon:interfacing` fails if retired registry/screen folders or namespaces return. `composer canon:interfacing:seal` reports the same as part of the final source seal.

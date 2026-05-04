# Interfacing boundary wave16 — CRUD resource descriptor boundary

Wave16 separates CRUD resource contribution metadata from generated view links.

## Decision

Owning components and internal contribution classes should publish URL-free CRUD resource descriptors through:

- `App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface`
- `App\Interfacing\Contract\Crud\CrudResourceDescriptorInterface`
- `App\Interfacing\Contract\Crud\CrudResourceDescriptor`

The Interfacing provider layer remains responsible for:

- Symfony route generation,
- fallback URL materialization,
- sample operation URLs,
- priority/deduplication,
- conversion into `Contract\View\CrudResourceLinkSetInterface` for existing views.

## Compatibility

`CrudResourceContributionInterface` remains as a deprecated compatibility alias extending the descriptor contribution contract. Existing contribution classes still compile while the canonical vocabulary moves to descriptors.

## Boundary rule

Contribution classes must not need `UrlGeneratorInterface` and should not build view link sets directly. Resource metadata belongs to `Contract\Crud`; generated links belong to `Contract\View`.

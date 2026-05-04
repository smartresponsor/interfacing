# Interfacing wave17.4 — DI alias validity hotfix

Symfony `lint:container` validates aliases where the service id is an interface.
A concrete service implementing only a canonical parent interface is not accepted
as an implementation of a deprecated child/transitional interface.

This hotfix keeps the canonical contracts intact and redirects deprecated access
aliases to compatibility wrapper classes that explicitly implement the deprecated
interfaces.

It also makes `ActionCatalog` explicitly implement the deprecated root
`ActionCatalogInterface` while it remains primarily typed by the canonical
`Catalog\ActionEndpointCatalogInterface`.

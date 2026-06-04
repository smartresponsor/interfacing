= Interfacing wave17.3 — InterfaceScreenViewBuilderService access contract hotfix

This hotfix restores the canonical access contract import and constructor type for `InterfaceScreenViewBuilderService`.

Runtime symptom fixed:

----
Cannot autowire service "App\Interfacing\Builder\View\InterfaceScreenViewBuilder":
argument "$access" ... has type "App\Interfacing\Service\View\AccessResolverInterface"
but this class was not found.
----

Canonical contract:

----
App\Interfacing\ResolverInterface\Shell\InterfaceCapabilityAccessResolverInterface
----

No routes, payloads, templates, or public contracts are changed by this hotfix.

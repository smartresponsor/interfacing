= Interfacing wave17.3 — InterfaceScreenViewBuilderService capability authorization hotfix

This hotfix restores the canonical capability-authorization contract import and constructor type for `InterfaceScreenViewBuilderService`.

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

No routes, payloads, templates, or public contracts are changed by this hotfix. This is a shell capability authorization fix, not account access ownership.

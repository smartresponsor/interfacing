= Interfacing wave17.3 — ScreenViewBuilder access contract hotfix

This hotfix restores the canonical access contract import and constructor type for `ScreenViewBuilder`.

Runtime symptom fixed:

----
Cannot autowire service "App\Interfacing\Service\Interfacing\View\ScreenViewBuilder":
argument "$access" ... has type "App\Interfacing\Service\Interfacing\View\AccessResolverInterface"
but this class was not found.
----

Canonical contract:

----
App\Interfacing\ServiceInterface\Interfacing\Shell\CapabilityAccessResolverInterface
----

No routes, payloads, templates, or public contracts are changed by this hotfix.

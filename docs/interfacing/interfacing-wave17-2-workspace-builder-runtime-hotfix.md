= Interfacing Wave 17.2: Workspace Builder Runtime Hotfix

This hotfix restores the concrete workspace view-builder class referenced by the Symfony DI configuration.

== Runtime failure

Symfony reported that the service id `App\Interfacing\Service\Interfacing\View\InterfacingWorkspaceViewBuilder` looked like a FQCN but no corresponding class existed.

== Fix

The patch overlays:

* `src/Service/Interfacing/View/InterfacingWorkspaceViewBuilder.php`
* `src/ServiceInterface/Interfacing/View/InterfacingWorkspaceViewBuilderInterface.php`

No public routes, route names, templates, payload shapes, or service ids are changed.

= Interfacing Wave 17.2: Workspace Builder Runtime Hotfix

Historical note: this document described a temporary runtime hotfix. The workspace view-builder layer has since been retired and the visible Interfacing pages now render directly without this contract.

== Runtime failure

Symfony reported that the service id `App\Interfacing\Service\Interfacing\View\InterfacingWorkspaceViewBuilder` looked like a FQCN but no corresponding class existed.

== Outcome

The temporary workspace builder and its interface were removed. Interfacing visible pages now render directly from the controller layer into the shell/provider templates, without the extra workspace aggregation contract.

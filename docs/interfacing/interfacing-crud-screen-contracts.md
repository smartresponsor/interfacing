# Interfacing CRUD screen contracts

The Ant Design / ProComponents center-body discipline is now driven by explicit screen metadata rather than per-screen Twig duplication.

Current contract objects:
- `CrudWorkbenchView`
- `CrudAction`
- `CrudFilterField`
- `CrudTableColumn`
- `CrudSidebarSection`

Current rendering rule:
- controllers build a workbench contract;
- shared Twig renders the contract;
- host-side component growth should feed metadata into this contract instead of cloning templates.

This keeps Interfacing in a renderer/workbench role while the host application remains the owner of route orchestration and business workflow.

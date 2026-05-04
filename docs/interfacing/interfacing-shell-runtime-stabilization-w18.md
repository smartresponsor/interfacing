# Interfacing Shell Runtime Stabilization W18

W18 stabilizes the host-wide shell line after the JSON action collision hotfix.

## Corrections

- Restores the shell provider/interface services that the shell diagnostics, navigation map, screen catalog, and layout preview controllers depend on.
- Registers the shell controllers as service controllers.
- Imports attribute routes for the shell diagnostics/navigation/application/screen/layout controllers.
- Restores the richer `ShellChromeProvider` contract keys used by the shared shell:
  - `rightPanelGroup`
  - `rightPanelEnabled`
  - `knownCrudResources`
  - `applicationDashboard`
- Mirrors the host-wide shell into both `template/base.html.twig` and `templates/base.html.twig` so pages inheriting the common Symfony base are covered consistently.

## Non-goals

Interfacing still does not own business persistence for foreign components. CRUD links remain bridge/navigation surfaces until each owning component provides the real backing workflow.

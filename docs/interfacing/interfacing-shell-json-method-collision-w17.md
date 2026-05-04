# Interfacing shell JSON action collision fix W17

This patch fixes a Symfony controller inheritance collision introduced by shell JSON endpoints.

`AbstractController` already defines `json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse`.
Controller action methods named `json(): JsonResponse` therefore override the framework helper with an incompatible signature and trigger a PHP compile error.

The route paths and route names remain unchanged. Only action method names are made explicit:

- `ShellPanelDiagnosticsController::shellDiagnosticsJson()`
- `ShellNavigationMapController::shellNavigationMapJson()`
- `ShellApplicationDashboardController::shellApplicationsJson()`
- `ShellScreenCatalogController::shellScreenCatalogJson()`
- `ShellLayoutPreviewController::shellLayoutPreviewJson()`

This keeps the public URLs stable while avoiding the inherited helper method collision.

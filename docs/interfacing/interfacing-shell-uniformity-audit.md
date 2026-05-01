# Interfacing shell uniformity audit

## Canon
User-facing HTML pages must render inside the shared `interfacing/base.html.twig` shell so the top bar, primary navigation, section navigation, and footer stay consistent.

## Findings from current slice
- CRUD workbench screens were still bypassing the shell because `template/interfacing/crud/workbench_base.html.twig` was a standalone HTML document.
- Shell consistency was already correct for page, doctor, and shell host templates that extend `interfacing/base.html.twig`.
- Intentional exceptions remain allowed for non-shell endpoints and fragments such as JSON endpoints, Prometheus-like metrics output, and live component fragment templates.

## Current fix
- CRUD workbench base now extends `interfacing/base.html.twig`.
- CRUD billing/order screens inherit the same top, left, and footer chrome through the shared base shell.

## Intentional non-shell exceptions
- `InterfacingMetricController` plain-text metrics response
- `DoctorJsonController` JSON response
- live component fragment templates under `template/interfacing/live/` and `template/interfacing/screen/`

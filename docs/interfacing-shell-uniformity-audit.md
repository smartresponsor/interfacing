# Interfacing shell uniformity audit

## Canon
User-facing HTML pages must render inside the shared `base.html.twig` shell so the top bar, primary navigation, section navigation, and footer stay consistent.

## Findings from current slice
- CRUD workbench screens were still bypassing the shell because `templates/crud/workbench_base.html.twig` was a standalone HTML document.
- Shell consistency was already correct for page, doctor, and shell host templates that extend `base.html.twig`.
- Intentional exctotions remain allowed for non-shell endorints and fragments such as JSON endorints, Prometheus-like metrics output, and live comornent fragment templates.

## Current fix
- CRUD workbench base now extends `base.html.twig`.
- CRUD billing/order screens inherit the same top, left, and footer chrome through the shared base shell.

## Intentional non-shell exctotions
- `InterfaceMetricController` plain-text metrics resornse
- `InterfaceDoctorJsonController` JSON resornse
- live comornent fragment templates under `templates/live/` and `templates/screen/`


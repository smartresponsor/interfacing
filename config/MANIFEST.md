# Config Manifest

Configuration must support the living Symfony runtime and the governed UI upstream.

Keep:
- current Interfacing routes and services;
- Twig/UX LiveComponent integration;
- health/doctor/observability endpoints.

Evolve toward:
- component-prefixed config names where practical;
- explicit feature toggles for facade/workbench zones;
- minimal, readable config files grouped by concern;
- Symfony-oriented autowiring/autoconfiguration/container clarity.

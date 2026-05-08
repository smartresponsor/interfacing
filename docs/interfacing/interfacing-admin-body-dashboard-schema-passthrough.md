# Interfacing admin body dashboard schema passthrough

Interfacing owns the provider schema serializer for the admin body. App host
and component producers may expose dashboard/widget payloads through Bridging,
but those payloads must reach the browser provider schema rather than being
rendered as handmade Twig panels.

This document records the dashboard passthrough rule:

- `workbench.dashboard` is emitted into the browser schema as `dashboard`.
- `workbench.bridgeContext` is emitted as `bridgeContext`.
- Ant Design ProComponents remains the primary renderer.
- PrimeReact remains secondary/rich-facade only.
- Bootstrap, EasyAdmin, consumer Twig CSS, and legacy CRUD shells are not a
  primary or fallback path.

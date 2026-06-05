# Interfacing current boundary

Interfacing is a route-less Symfony package. It must not own HTTP routes, controllers, business feature pages, CRUD lifecycle, Accessing auth-flow, Messaging pages, Product/Category/Project showcases, Billing/Order/Category clients, or host registry/public dashboard surfaces.

Allowed responsibilities:

- rendering contracts and DTOs;
- renderer services;
- shell/template primitives without route generation;
- view builders and mappers that do not own HTTP endpoints;
- CLI/local diagnostics without public route exposure.

Templates are intentionally left untouched in this cleanup wave. Domain templates must be audited in a separate wave.

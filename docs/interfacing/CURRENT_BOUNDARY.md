# Interfacing current boundary

Interfacing is a Symfony runtime application and bundle for shared interface templates.

From the outside, Interfacing is passive: it does not query sibling components,
discover external business state, or own upstream data lookup. Inside its own
runtime, it may own business routes and controllers when they express real
interface behavior.

Interfacing must not own generic CRUD route grammar, generic CRUD operation
dispatch, or generic CRUD controllers outside an explicit EasyAdmin admin
runtime. EasyAdmin is the allowed admin exception.

Allowed responsibilities:

- rendering contracts and DTOs;
- renderer services;
- shell/template primitives;
- Interfacing-owned business routes and controllers;
- view builders and mappers for interface-owned behavior;
- EasyAdmin admin runtime when explicitly scoped to Interfacing administration;
- CLI/local diagnostics without public route exposure.

Templates are intentionally left untouched in this cleanup wave. Domain templates must be audited in a separate wave.
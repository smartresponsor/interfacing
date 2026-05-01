# Interfacing runtime bridges

The Runtime Bridges screen (`/interfacing/bridges`) makes the handoff between Interfacing and owning Smart Responsor components explicit.

Interfacing owns:

- shell navigation;
- route-transparent operator surfaces;
- CRUD route grammar;
- table/form/action/affordance frames;
- bridge visibility and readiness reporting.

Owning components own:

- host routes and controllers;
- query handlers for index/show;
- command handlers for create/update/delete/bulk operations;
- field schema, validation and identifiers;
- authorization and policy mapping;
- persistence and audit evidence;
- fixtures/providers used for real records.

No business demo rows should be introduced in Interfacing to make a planned bridge look connected.

= Interfacing CRUD Resource-Aware Row Detail And Form Schema

The CRUD workbench now differentiates not only action wording and filter vocabulary,
but also the selected-row detail facts and the edit/new form schema.

== Intent

* keep the renderer entity-agnostic at the route-contract level
* allow each resource path to supply different fact labels and form-field copy
* make detail and form modes visibly different between order and meter resources

== Current resource-aware behavior

=== sales/order

* row detail facts use request-oriented labels such as `Request ref`, `Workflow state`, `Submitted at`, `Gross total`, and `Customer email`
* form schema uses order-specific fields and help copy

=== billing/meter

* row detail facts use meter-oriented labels such as `Meter ref`, `Reading state`, `Reading window`, `Billed amount`, and `Settlement state`
* form schema uses reading and settlement wording instead of generic field names

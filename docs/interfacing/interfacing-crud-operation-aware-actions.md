= Interfacing CRUD operation-aware actions

This wave narrows the center-body workbench so that action bars and sidebar command actions
follow the active CRUD operation instead of exposing one broad action set everywhere.

== Mode behavior

* `index` / collection
** header: Create, Refresh, Show, Edit, Delete, Next
** row actions: Open, Edit, Delete
** sidebar: full context + selected record + command form

* `show` / detail
** header: Edit, Delete, Back to list, Next
** row actions: Open, Edit
** sidebar: route context + selected record + command form

* `new` / `edit` / form
** header: Save, Save draft, Cancel
** row actions: Open, Edit
** sidebar: route context + command form

* `delete` / destructive
** header: Delete, Cancel, Back to list
** row actions: Open
** sidebar: route context only

This keeps the renderer aligned with host CRUD semantics while making the page behavior
closer to an actual workbench instead of a static demo template.

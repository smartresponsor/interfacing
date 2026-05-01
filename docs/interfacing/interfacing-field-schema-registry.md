# Interfacing field schema registry

The field schema registry records what each owning Smart Responsor component must provide before Interfacing can render real CRUD tables and form frames.

Interfacing owns only the shell, route grammar, table/form frame and visual affordances. Owning components own identifiers, labels, field schema, validation, relationship lookups, persistence handlers, fixtures and audit evidence.

The registry grades each component as `missing`, `draft` or `schema_ready` and is intentionally derived from the contract registry instead of from demo data.

# Interfacing CRUD route expectations

W5 adds a machine-readable route expectation export for the CRUD Explorer.

## Endpoint

`/interfacing/crud/explorer/route-expectations.json`

The payload publishes every known Smart Responsor CRUD resource multiplied by the standard operation set:

- `index` -> `app_crud_index` -> `/{resourcePath}/`
- `new` -> `app_crud_new` -> `/{resourcePath}/new/`
- `show` -> `app_crud_show` -> `/{resourcePath}/{id}`
- `edit` -> `app_crud_edit` -> `/{resourcePath}/edit/{id}`
- `delete` -> `app_crud_delete` -> `/{resourcePath}/delete/{id}`

## Purpose

This export is a smoke contract for host applications and future component wiring. It does not claim that every planned component has persistence behind it. It only states that Interfacing can publish fair, route-compatible CRUD affordances for connected, canonical and planned resources.

## Boundary

Interfacing owns the shell, link matrix, sample URLs and generic preview bridge. Owning components remain responsible for concrete controllers, entity persistence, validation and destructive business behavior.

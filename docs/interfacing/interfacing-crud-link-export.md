# Interfacing CRUD link export

W4 adds a machine-readable CRUD link directory beside the visual explorer.

## Endpoint

`/interfacing/crud/explorer/links.json`

The endpoint publishes:

- resource id, component, label, resource path and status;
- generated sample URLs for index, new, show, edit and delete;
- canonical route patterns for show, edit and delete;
- counts by resource, component and status.

## Boundary

The export is an Interfacing navigation contract. It does not claim that an owning component has already implemented persistence or business handlers. Planned resources intentionally resolve through the generic bridge so the host application can expose real address-bar links before every component is wired.

## EasyAdmin compensation

This gives the host application a quick replacement for the default EasyAdmin route index habit: operators can see, click and export every known Smart Responsor CRUD surface from one place.

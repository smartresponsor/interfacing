# Interfacing CRUD form frames

This wave adds the `/interfacing/forms` shell-native surface.

The page exists to make New, Edit, and Delete operation affordances visible for every known Smart Responsor CRUD resource without introducing Interfacing-owned business data.

## Boundary

Interfacing owns:

- shell rendering;
- route transparency;
- operation frame layout;
- action affordances;
- status labels.

The owning component owns:

- fixtures;
- real records and identifiers;
- form fields and validation;
- save/delete handlers;
- authorization and audit evidence.

## Canonical route grammar

- `/{resource}/new/`
- `/{resource}/edit/{id}`
- `/{resource}/delete/{id}`

Sample identifiers are route probes only. They are not stored by Interfacing.

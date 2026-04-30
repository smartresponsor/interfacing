# Interfacing CRUD Explorer

Interfacing now exposes a permanent `CRUD Explorer` screen under `/interfacing/crud/explorer`.

Purpose:
- make canonical CRUD entry points visible from the shell;
- let operators open `index` and `new` routes directly;
- keep generic CRUD discovery in Interfacing while Cruding remains the owner of CRUD route semantics.

Law:
- generic CRUD links come from the `Cruding -> Interfacing` posture;
- custom component links remain in their component-specific bridges;
- the explorer is a shell-native discovery surface, not a replacement for component-specific screens.

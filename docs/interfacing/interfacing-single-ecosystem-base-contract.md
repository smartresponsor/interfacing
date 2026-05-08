# Interfacing single ecosystem base contract

## Decision

All host-connected applications must enter one shared ecosystem base. Interfacing
provides that base shell; application-specific screens render their page content
inside the central `body` slot.

## Canonical model

```text
HostHub / ecosystem shell
  - top menu
  - left navigation panels
  - right context panel
  - quick menu
  - footer menu
  - body slot
      - Cruding, Ordering, Paying, Shipping, or any other page content
```

## Consequences

- Cruding is not special-cased in Interfacing.
- No Interfacing-owned files should be copied into a host application as the
  primary integration model.
- No Twig adapter should exist only to wrap Cruding into another adapter chain.
- Component pages should extend `base.html.twig` when running in the host app,
  or `interfacing/base.html.twig` for Interfacing-local pages.
- CRUD screens should provide content/view-models, not a separate shell.

## Guard

Run the static guard from the Interfacing repository root:

```bash
php tools/interfacing/single-ecosystem-base-guard.php
```

PowerShell wrapper:

```powershell
powershell -ExecutionPolicy Bypass -File tools/interfacing/single-ecosystem-base-guard.ps1
```

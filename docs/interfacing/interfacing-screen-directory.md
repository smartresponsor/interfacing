# Interfacing screen directory

The screen directory is a shell-native presentation of screen and action links that are already known to the Interfacing runtime or supplied by the host.

## Boundary

Interfacing owns shell framing, presentation, status display, and empty/error/loading rendering contracts. It does not own generic application CRUD URI grammar, CRUD dispatch, sibling component discovery, business fixtures, or business data lookup.

Generic application CRUD routes and operations are owned by Cruding. EasyAdmin CRUD remains the explicit back-office exception inside the Interfacing admin runtime.

## Route

```text
/interfacing/screens
```

The directory may render links and metadata supplied through canonical Interfacing contracts, but it must not invent routes for external components.

## Statuses

- `connected`: the link is backed by a route or action known to the current runtime.
- `canonical`: the entry conforms to the current Interfacing screen/action contract.
- `planned`: descriptive metadata only; no executable route is fabricated.

Real resource identifiers, persistence, permissions, CRUD route grammar, and business operations remain owned by Cruding or the corresponding business component.

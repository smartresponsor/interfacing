Interfacing package install

Requirements:
- PHP 8.4+
- Composer 2
- Symfony host application with FrameworkBundle, TwigBundle, SecurityBundle, UX TwigComponent and UX LiveComponent

Package posture:
- Composer package: `smartresponsor/interfacing`
- PSR-4 root: `App\Interfacing\ => src/`
- Bundle class: `App\Interfacing\InterfacingBundle`
- Primary runtime templates stay under `template/`, with `templates/` kept as fallback compatibility surface

Host wiring expectations:
1) Require the package in the host application
2) Enable `App\Interfacing\InterfacingBundle` in the host bundle map
3) Import package routes from `@InterfacingBundle/config/routes/` as needed
4) Configure the bundle through the `interfacing:` config tree instead of host-side service glue
5) Do not duplicate Interfacing tags, aliases, or scalar query-service arguments in the host application
6) Keep visual proving and runtime inspection in the host app, not by turning this repository back into a standalone product app


Security boundary:
- Interfacing does not ship a package-level `config/packages/security.yaml`.
- Firewalls, access_control, authenticators, providers, and password hashers belong to the host application.
- The package only consumes host security services through access-resolver abstractions.

Canonical host config surface:
```yaml
interfacing:
  tenant_default: default
  billing_meter:
    base_url: 'http://127.0.0.1'
    path: '/billing/meter'
  order_summary:
    base_url: 'http://127.0.0.1'
    path: '/order/summary'
  category_api:
    base_url: 'http://127.0.0.1:8080'
    timeout_ms: 2500
    list_path: '/category/admin/category'
    read_path: '/category/admin/category/{id}'
    save_path: '/category/admin/category/{id}'
```

Useful checks inside this repository:
- `composer lint`
- `composer lint:yaml`
- `composer lint:container`
- `composer lint:twig`
- `composer cs:check`
- `composer test`

Notes:
- Billing and order screens are wired in `config/routes/interfacing.yaml`
- Health wiring remains in `config/routes/interfacing_health.yaml`
- UX LiveComponent routes stay exposed under `/_components` when the host imports the UX route file
- Local `bin/console` and `Kernel` remain only as sandbox/development support for the package repository itself

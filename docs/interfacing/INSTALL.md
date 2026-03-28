Interfacing install

Requirements:
- PHP 8.4+
- Composer 2

Boot wiring:
1) Install with `composer install`
2) Boot the console with `php bin/console`
3) Keep `App\\ => src/` as the only Composer root namespace
4) Keep the canonical application trees under `src/`
5) Twig loads both `template/` and `templates/`, with the existing `template/` tree preserved as the primary runtime source

Useful checks:
- `composer lint`
- `composer lint:yaml`
- `composer lint:container`
- `composer lint:twig`
- `composer cs:check`
- `composer test`

Notes:
- Billing and order screens are wired via `config/routes/interfacing.yaml`
- Health remains wired via `config/routes/interfacing_health.yaml`
- UX LiveComponent routes are exposed under `/_components`

# Local Standalone Console

Interfacing is a Symfony package/library, but the repository keeps a local standalone console for package-local checks.

Canonical entrypoint:

```bash
php bin/console
```

Useful local checks:

```bash
php bin/console debug:router
php bin/console lint:container
php bin/console lint:twig templates
php bin/console lint:yaml config src tests
php bin/console interfacing:doctor
php bin/console interfacing:doctor-json
php bin/console interfacing:doctor-summary
```

Boundary rule:

- the standalone console is only a local sandbox/check runner;
- it must not make Interfacing own `/access/*`, sign-in, sign-up, sign-out, session, credential, or security flows;
- account/auth routes remain owned by Accessing.

Kernel classes:

- canonical: `App\Interfacing\InterfaceKernel`;
- compatibility alias: `App\Interfacing\Kernel` for older local tooling references only.

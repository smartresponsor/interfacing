# Symfony Manifest

Symfony-specific integration glue only.

## Canonical boundary

This directory owns Symfony integration helpers only: attributes, compiler passes, and integration metadata.
It must not define a second Symfony bundle or a second dependency-injection extension.

Canonical runtime entrypoints are:

- `src/InterfacingBundle.php`
- `src/DependencyInjection/InterfacingExtension.php`

Retired duplicate entrypoints:

- `src/Integration/Symfony/InterfacingBundle.php`
- `src/Integration/Symfony/DependencyInjection/InterfacingExtension.php`

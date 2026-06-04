# Symfony Manifest

Symfony-specific integration glue only.

## Canonical boundary

This directory owns Symfony integration helpers only: attributes, compiler passes, and integration metadata.
It must not define a second Symfony bundle or a second dependency-injection extension.

Canonical runtime entrypoints are:

- `src/InterfaceBundle.php`
- `src/DependencyInjection/InterfaceExtension.php`

Retired duplicate entrypoints:

- `src/Integration/Symfony/InterfaceBundle.php`
- `src/Integration/Symfony/DependencyInjection/InterfaceExtension.php`

# Interfacing Admin Body Consumer Guide

This guide describes how HostHub, Cruding, and other Smart Responsor components should consume the Interfacing admin body contract.

## Correct integration shape

A component should enter the shared ecosystem shell and render its admin screen in the central body slot.

```text
component route/controller
  -> page template
      -> shared ecosystem base
          -> central body slot
              -> Interfacing admin body mount
                  -> schema payload
                  -> Ant Design Pro renderer when available
                  -> Twig provider-less UI otherwise
```

## What a component must not do

- Do not create a component-specific shell for CRUD pages.
- Do not bypass the shared `base.html.twig` / Interfacing shell chain.
- Do not use a Cruding-specific adapter as the shell root.
- Do not copy generated override files into HostApp as the primary model.
- Do not promote PrimeReact to the primary CRUD/admin table-form renderer.
- Do not encode business authorization only in the browser; backend security remains authoritative.

## What a component should provide

A component or bridge should provide enough context for the schema/resource layer:

- resource name and label;
- operation: `index`, `show`, `new`, `edit`, or `delete`;
- columns and filters for list pages;
- form fields for create/edit pages;
- row/header/detail/form actions;
- content locale options if the resource is localizable;
- action state from backend authorization: visible, disabled, reason, confirmation requirement.

## Provider responsibility

Ant Design ProComponents owns the canonical admin workbench rendering:

- `PageContainer` for page header and context;
- `ProTable` for table-first collection pages;
- `ProForm` for create/edit forms;
- `Descriptions` / `ProCard` for read-only detail pages.

PrimeReact may be used for rich facade or specialized interactive widgets, but it must not silently replace the Ant Design Pro CRUD workbench for the admin body.

## Twig responsibility

Twig remains important, but limited:

- shared shell inheritance;
- central body slot;
- mount element;
- schema payload;
- modest provider-less markup for no-provider/no-JS/smoke;
- static contract markers used by guards.

Twig provider-less UI should be conservative. It is a safety baseline, not the final admin design system.

## Local validation commands

Run the static and runtime checks after applying a patch:

```powershell
php -l src/Contract/Ui/AdminBodyDocumentationContract.php
php -l tests/Interfacing/Ui/AdminBodyDocumentationContractTest.php
php -l tools/interfacing/admin-body-mount-contract-guard.php
node --check tools/interfacing/admin-body-runtime-smoke.mjs
node tools/interfacing/admin-body-runtime-smoke.mjs
php tools/interfacing/admin-body-mount-contract-guard.php
php tools/interfacing/single-ecosystem-base-guard.php
vendor/bin/phpunit --filter AdminBodyDocumentationContractTest
```

## Practical rule for Cruding

Cruding should not be special-cased. A Cruding screen is just another admin body consumer:

```text
Cruding content -> shared ecosystem base -> admin body mount -> Ant Design Pro workbench
```

That is enough. No extra shell, no HostApp copy workflow, no special bridge shell.

## UI provider canon for consumers

Before changing consumer admin/CRUD templates, read `docs/interfacing/interfacing-admin-body-ui-provider-canon.md` and run:

```bash
php tools/interfacing/admin-body-ui-provider-canon-guard.php
```

Consumer repositories must not infer Bootstrap or handmade Twig CSS from `composer.json`. Composer packages provide Symfony/PHP infrastructure. The admin body visual contract is provider-owned: Ant Design ProComponents is primary, PrimeReact is secondary, and Twig remains shell/slots/schema/provider-less path.


## Strict provider rendering

See `docs/interfacing/interfacing-admin-body-strict-provider-rendering.md`. Admin body UI is provider-required: Ant Design ProComponents renders the primary workbench, PrimeReact remains secondary rich-facade, and Twig publishes only shell/mount/schema/script wiring. Run `npm install`, `npm run ui:build`, and then `php tools/interfacing/admin-body-rc-readiness.php`.

## Visible page adoption audit

Before migrating a consumer repository, run:

```bash
php tools/interfacing/admin-body-consumer-provider-adoption-audit.php --consumer-root=../Cruding --strict
```

The audit is intentionally strict: visible admin/workbench pages must expose the Interfacing admin body provider mount and must not continue Bootstrap-like or handmade Twig/CSS admin bodies.

## Multi-consumer adoption runner

Run `tools/interfacing/admin-body-consumer-provider-adoption-runner.php --defaults --format=markdown --output=var/interfacing-visible-page-provider-adoption-runner.md` from Interfacing to identify consumer pages that still render handmade Twig/CSS instead of the provider-owned admin body.



## Ecosystem/e-commerce UI coverage

Interfacing maintains an ecosystem-wide page coverage map at `docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md`. Consumer adoption work must compare real pages against this component/page family map instead of treating one repository archive as the whole UI surface. Run `php tools/interfacing/admin-body-ecosystem-ui-coverage-audit.php` before provider adoption waves.

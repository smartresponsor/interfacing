<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

const PROVIDER_PAGE_TEMPLATE = 'interfacing/admin/body/provider_page.html.twig';

$targets = [
    'Cataloging' => [
        'templates/category/admin/audit.html.twig' => ['Catalog category audit', 'catalog-category-audit', 'audit'],
        'templates/category/admin/batch_edit.html.twig' => ['Catalog category batch edit', 'catalog-category', 'batch-edit'],
        'templates/category/admin/dlq.html.twig' => ['Catalog category DLQ', 'catalog-category-dlq', 'index'],
        'templates/category/admin/list.html.twig' => ['Catalog category admin', 'catalog-category', 'index'],
        'templates/category/admin/mobile.html.twig' => ['Catalog category mobile', 'catalog-category-mobile', 'index'],
        'templates/category/admin/ops.html.twig' => ['Catalog category operations', 'catalog-category-ops', 'index'],
        'templates/category/admin/perms.html.twig' => ['Catalog category permissions', 'catalog-category-permissions', 'index'],
        'templates/category/admin/_status.html.twig' => ['Catalog category status', 'catalog-category-status', 'show'],
        'templates/category/form.html.twig' => ['Catalog category form', 'catalog-category', 'edit'],
        'templates/category/list.html.twig' => ['Catalog categories', 'catalog-category', 'index'],
        'templates/category/merchant/list.html.twig' => ['Merchant catalog categories', 'catalog-merchant-category', 'index'],
        'templates/category/tree.html.twig' => ['Catalog category tree', 'catalog-category-tree', 'index'],
    ],
    'Cruding' => [
        'templates/crud/edit.html.twig' => ['CRUD edit', 'crud-resource', 'edit'],
        'templates/crud/index.html.twig' => ['CRUD resources', 'crud-resource', 'index'],
        'templates/crud/new.html.twig' => ['CRUD create', 'crud-resource', 'new'],
        'templates/crud/show.html.twig' => ['CRUD detail', 'crud-resource', 'show'],
        'templates/relation/list.html.twig' => ['CRUD relations', 'crud-relation', 'index'],
    ],
    'Vendoring' => [
        'templates/ops/vendor_transactions/index.html.twig' => ['Vendor transactions', 'vendor-transaction', 'index'],
        'templates/vendor/local_dev/home.html.twig' => ['Vendor workbench', 'vendor', 'index'],
        'templates/_macros/crud.html.twig' => ['Vendor CRUD macros', 'vendor-crud-macro', 'macro-review'],
    ],
];

$options = [
    'consumer-root' => [],
    'apply' => false,
    'format' => 'text',
    'output' => null,
    'include-macros' => false,
    'force-direct-template-rewrite' => false,
];

foreach (array_slice($argv, 1) as $arg) {
    if (str_starts_with($arg, '--consumer-root=')) {
        $options['consumer-root'][] = substr($arg, strlen('--consumer-root='));
        continue;
    }

    if ($arg === '--apply') {
        $options['apply'] = true;
        continue;
    }

    if ($arg === '--include-macros') {
        $options['include-macros'] = true;
        continue;
    }

    if ($arg === '--force-direct-template-rewrite') {
        $options['force-direct-template-rewrite'] = true;
        continue;
    }

    if (str_starts_with($arg, '--format=')) {
        $options['format'] = substr($arg, strlen('--format='));
        continue;
    }

    if (str_starts_with($arg, '--output=')) {
        $options['output'] = substr($arg, strlen('--output='));
        continue;
    }

    if ($arg === '--help' || $arg === '-h') {
        echo helpText();
        exit(0);
    }
}

if ($options['consumer-root'] === []) {
    $options['consumer-root'] = ['../Cataloging', '../Cruding', '../Vendoring'];
}

$projectRoot = dirname(__DIR__, 2);

if ($options['apply'] && !$options['force-direct-template-rewrite']) {
    fwrite(STDERR, "Direct consumer template rewrites are not the primary migration path. Bridge owns route/resource adoption and Interfacing renders provider-owned UI. Re-run only with --force-direct-template-rewrite for an explicit local repair.\n");
    exit(2);
}

$results = [];

foreach ($options['consumer-root'] as $consumerRootOption) {
    $consumerRoot = normalizePath($projectRoot . DIRECTORY_SEPARATOR . $consumerRootOption);
    $consumer = basename($consumerRoot);
    $consumerTargets = $targets[$consumer] ?? [];

    if ($consumerTargets === []) {
        $results[] = [
            'consumer' => $consumer,
            'root' => $consumerRoot,
            'template' => '',
            'status' => 'unsupported-consumer',
            'message' => 'No known migration target map is registered for this consumer.',
        ];
        continue;
    }

    foreach ($consumerTargets as $relativeTemplate => [$title, $resource, $operation]) {
        $templatePath = $consumerRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativeTemplate);

        if (!is_file($templatePath)) {
            $results[] = [
                'consumer' => $consumer,
                'root' => $consumerRoot,
                'template' => $relativeTemplate,
                'status' => 'missing',
                'message' => 'Template is not present in this consumer root.',
            ];
            continue;
        }

        if (str_contains($relativeTemplate, '/_macros/') || str_contains($relativeTemplate, '\\_macros\\')) {
            if (!$options['include-macros']) {
                $results[] = [
                    'consumer' => $consumer,
                    'root' => $consumerRoot,
                    'template' => $relativeTemplate,
                    'status' => 'macro-review-required',
                    'message' => 'Macro template was not rewritten by default. Re-run with --include-macros only after confirming caller compatibility.',
                ];
                continue;
            }

            $content = renderMacroProviderTemplate($title, $resource);
        } else {
            $content = renderProviderPageTemplate($title, $resource, $operation, $consumer, $relativeTemplate);
        }

        $current = file_get_contents($templatePath);
        if ($current === $content) {
            $results[] = [
                'consumer' => $consumer,
                'root' => $consumerRoot,
                'template' => $relativeTemplate,
                'status' => 'already-provider-migrated',
                'message' => 'Template already matches the provider migration output.',
            ];
            continue;
        }

        if ($options['apply']) {
            file_put_contents($templatePath, $content);
        }

        $results[] = [
            'consumer' => $consumer,
            'root' => $consumerRoot,
            'template' => $relativeTemplate,
            'status' => $options['apply'] ? 'provider-migrated' : 'would-migrate',
            'message' => $options['apply'] ? 'Template was replaced with canonical Interfacing provider page entry by explicit forced local repair.' : 'Dry run only. Normal migration should be implemented in Bridge route/resource adoption, not direct consumer template rewrite.',
        ];
    }
}

$output = match ($options['format']) {
    'markdown' => renderMarkdown($results, $options['apply']),
    'json' => json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL,
    default => renderText($results, $options['apply']),
};

if (is_string($options['output']) && $options['output'] !== '') {
    $outputPath = $options['output'];
    if (!str_starts_with($outputPath, DIRECTORY_SEPARATOR) && !preg_match('/^[A-Za-z]:[\/\\\\]/', $outputPath)) {
        $outputPath = $projectRoot . DIRECTORY_SEPARATOR . $outputPath;
    }

    $outputDir = dirname($outputPath);
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0777, true);
    }

    file_put_contents($outputPath, $output);
}

echo $output;

$failed = array_filter($results, static fn (array $row): bool => in_array($row['status'], ['unsupported-consumer'], true));
exit($failed === [] ? 0 : 2);

function renderProviderPageTemplate(string $title, string $resource, string $operation, string $consumer, string $relativeTemplate): string
{
    $titleEscaped = twigString($title);
    $resourceEscaped = twigString($resource);
    $operationEscaped = twigString($operation);
    $consumerEscaped = twigString($consumer);
    $sourceEscaped = twigString(str_replace('\\', '/', $relativeTemplate));

    return <<<TWIG
{# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp #}
{#
  Provider-owned UI migration.

  This consumer page intentionally does not render handmade Twig tables, forms,
  Bootstrap-like classes, or inline admin CSS. It enters the Interfacing admin
  body provider page and is rendered by the canonical providers:
  Ant Design ProComponents as primary admin/workbench renderer and PrimeReact
  as secondary rich-facade provider.
#}
{% set adminProviderPageTitle = '{$titleEscaped}' %}
{% set adminProviderResourceName = '{$resourceEscaped}' %}
{% set adminProviderResourceLabel = '{$titleEscaped}' %}
{% set adminProviderOperation = '{$operationEscaped}' %}
{% set adminProviderSurface = 'admin' %}
{% set adminProviderWorkbench = {
  title: '{$titleEscaped}',
  consumer: '{$consumerEscaped}',
  sourceTemplate: '{$sourceEscaped}',
  routeContext: {
    resourcePath: '{$resourceEscaped}',
    resourceLabel: '{$titleEscaped}',
    operation: '{$operationEscaped}',
    surface: 'admin'
  }
} %}

{% extends 'interfacing/admin/body/provider_page.html.twig' %}

TWIG;
}

function renderMacroProviderTemplate(string $title, string $resource): string
{
    $titleEscaped = twigString($title);
    $resourceEscaped = twigString($resource);

    return <<<TWIG
{# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp #}
{#
  Provider-owned macro surface.

  This macro file is no longer a handmade CRUD renderer. Callers should migrate
  to page-level Interfacing provider entries. The macro below is intentionally
  thin and emits a provider-page include only for transitional caller surfaces
  that cannot yet extend the provider page directly.
#}
{% macro provider_mount(title = '{$titleEscaped}', resource = '{$resourceEscaped}', operation = 'index') %}
  {% include 'interfacing/admin/body/mount.html.twig' with {
    workbench: {
      title: title,
      routeContext: {
        resourcePath: resource,
        resourceLabel: title,
        operation: operation,
        surface: 'admin'
      }
    },
    provider: 'antd-pro',
    secondaryProvider: 'primereact',
    resourceName: resource,
    resourceLabel: title,
    operation: operation,
    surface: 'admin',
    defaultView: 'table',
    viewModes: ['table', 'cards']
  } only %}
{% endmacro %}

TWIG;
}

function twigString(string $value): string
{
    return str_replace(["\\", "'"], ["\\\\", "\\'"], $value);
}

function renderText(array $results, bool $apply): string
{
    $lines = [];
    $lines[] = 'Interfacing consumer provider migration executor: ' . ($apply ? 'APPLY' : 'DRY-RUN');

    foreach ($results as $row) {
        $lines[] = sprintf(
            '- %s | %s | %s | %s',
            $row['consumer'],
            $row['template'] !== '' ? $row['template'] : '(consumer)',
            $row['status'],
            $row['message']
        );
    }

    return implode(PHP_EOL, $lines) . PHP_EOL;
}

function renderMarkdown(array $results, bool $apply): string
{
    $lines = [];
    $lines[] = '# Interfacing consumer provider migration executor';
    $lines[] = '';
    $lines[] = 'Mode: ' . ($apply ? 'apply' : 'dry-run');
    $lines[] = '';
    $lines[] = '| Consumer | Template | Status | Notes |';
    $lines[] = '| --- | --- | --- | --- |';

    foreach ($results as $row) {
        $lines[] = sprintf(
            '| `%s` | `%s` | `%s` | %s |',
            $row['consumer'],
            $row['template'] !== '' ? $row['template'] : '(consumer)',
            $row['status'],
            str_replace('|', '\\|', $row['message'])
        );
    }

    return implode(PHP_EOL, $lines) . PHP_EOL;
}

function normalizePath(string $path): string
{
    $real = realpath($path);
    if ($real !== false) {
        return $real;
    }

    return rtrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
}

function helpText(): string
{
    return <<<'TXT'
Usage:
  php tools/interfacing/admin-body-consumer-provider-migration-executor.php [options]

Options:
  --consumer-root=../Cataloging   Consumer root to migrate. May be repeated.
  --apply                         Explicit local repair only; requires --force-direct-template-rewrite.
  --include-macros                Include known macro templates during explicit local repair.
  --force-direct-template-rewrite  Required with --apply; Bridge adoption is the normal path.
  --format=text|markdown|json      Output format.
  --output=var/report.md           Optional output path.
  --help                           Show this help.

TXT;
}

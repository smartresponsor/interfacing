<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * Consumer visible-page adoption audit for canonical Interfacing provider rendering.
 *
 * Usage:
 *   php tools/interfacing/admin-body-consumer-provider-adoption-audit.php
 *   php tools/interfacing/admin-body-consumer-provider-adoption-audit.php --consumer-root=../Cruding --strict
 *   php tools/interfacing/admin-body-consumer-provider-adoption-audit.php --consumer-root=../App --consumer-root=../Vendoring --format=markdown
 */
$root = dirname(__DIR__, 2);
$options = parseOptions($argv);
$consumerRoots = $options['consumerRoots'];
$strict = $options['strict'];
$format = $options['format'];
$outputPath = $options['output'];

$errors = [];
$rows = [];

foreach ([
    'src/Contract/Ui/AdminBodyConsumerProviderAdoptionContract.php',
    'docs/interfacing/interfacing-visible-page-provider-adoption-audit.md',
    'src/Contract/Ui/AdminBodyUiProviderCanonContract.php',
    'src/Contract/Ui/AdminBodyStrictProviderRenderingContract.php',
    'template/interfacing/admin/body/mount.html.twig',
    'template/interfacing/admin/body/schema.html.twig',
] as $requiredFile) {
    if (!is_file($root . '/' . $requiredFile)) {
        $errors[] = 'Missing required Interfacing adoption file: ' . $requiredFile;
    }
}

if ($consumerRoots === []) {
    $consumerRoots[] = $root;
}

foreach ($consumerRoots as $consumerRoot) {
    $resolvedRoot = resolveRoot($consumerRoot, $root);
    if (!is_dir($resolvedRoot)) {
        $errors[] = 'Consumer root does not exist: ' . $consumerRoot;
        continue;
    }

    $rows = array_merge($rows, scanConsumerRoot($resolvedRoot));
}

$report = $format === 'markdown' ? renderMarkdown($rows, $errors) : renderText($rows, $errors);
if ($outputPath !== null) {
    $outputAbsolutePath = $outputPath;
    if (!str_starts_with(str_replace('\\', '/', $outputAbsolutePath), '/')) {
        $outputAbsolutePath = $root . '/' . $outputPath;
    }
    $outputDirectory = dirname($outputAbsolutePath);
    if (!is_dir($outputDirectory)) {
        mkdir($outputDirectory, 0777, true);
    }
    file_put_contents($outputAbsolutePath, $report);
} else {
    fwrite(STDOUT, $report);
}

$findings = array_filter($rows, static fn (array $row): bool => $row['status'] !== 'provider-adopted');
if ($errors !== [] || ($strict && $findings !== [])) {
    fwrite(STDERR, "Interfacing visible page provider adoption audit: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    if ($strict && $findings !== []) {
        foreach ($findings as $finding) {
            fwrite(STDERR, '- ' . $finding['consumer'] . ': ' . $finding['path'] . ' => ' . $finding['status'] . ' (' . implode('; ', $finding['findings']) . ")\n");
        }
    }
    exit(2);
}

fwrite(STDERR, "Interfacing visible page provider adoption audit: OK\n");
exit(0);

/** @return array{consumerRoots:list<string>,strict:bool,format:string,output:?string} */
function parseOptions(array $argv): array
{
    $consumerRoots = [];
    $strict = false;
    $format = 'text';
    $output = null;

    foreach (array_slice($argv, 1) as $argument) {
        if ($argument === '--strict') {
            $strict = true;
            continue;
        }
        if (str_starts_with($argument, '--consumer-root=')) {
            $consumerRoots[] = substr($argument, strlen('--consumer-root='));
            continue;
        }
        if (str_starts_with($argument, '--format=')) {
            $format = substr($argument, strlen('--format='));
            continue;
        }
        if (str_starts_with($argument, '--output=')) {
            $output = substr($argument, strlen('--output='));
            continue;
        }
    }

    if (!in_array($format, ['text', 'markdown'], true)) {
        $format = 'text';
    }

    return [
        'consumerRoots' => $consumerRoots,
        'strict' => $strict,
        'format' => $format,
        'output' => $output,
    ];
}

function resolveRoot(string $consumerRoot, string $defaultRoot): string
{
    $normalized = str_replace('\\', '/', $consumerRoot);
    if ($normalized === '') {
        return $defaultRoot;
    }

    if (str_starts_with($normalized, '/') || preg_match('/^[A-Za-z]:\//', $normalized) === 1) {
        return rtrim($consumerRoot, '\\/');
    }

    return rtrim($defaultRoot . '/' . $consumerRoot, '\\/');
}

/** @return list<array{consumer:string,path:string,status:string,findings:list<string>}> */
function scanConsumerRoot(string $consumerRoot): array
{
    $rows = [];
    $consumerName = basename(str_replace('\\', '/', $consumerRoot));
    $templateRoots = [];
    foreach (['template', 'templates'] as $relative) {
        if (is_dir($consumerRoot . '/' . $relative)) {
            $templateRoots[] = $consumerRoot . '/' . $relative;
        }
    }

    if ($templateRoots === []) {
        return [[
            'consumer' => $consumerName,
            'path' => '(no template directory)',
            'status' => 'no-visible-twig-surface-found',
            'findings' => ['No template/ or templates/ directory found; manual route inventory may be required.'],
        ]];
    }

    foreach ($templateRoots as $templateRoot) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($templateRoot, FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            if (!$file instanceof SplFileInfo || !$file->isFile() || $file->getExtension() !== 'twig') {
                continue;
            }

            $path = $file->getPathname();
            $relativePath = normalizeRelativePath($consumerRoot, $path);
            $contents = (string) file_get_contents($path);

            if (isProviderInfrastructureTemplate($relativePath)) {
                continue;
            }

            $findings = analyzeTemplate($relativePath, $contents);
            $status = $findings === [] ? 'provider-adopted' : 'needs-provider-adoption';

            $rows[] = [
                'consumer' => $consumerName,
                'path' => $relativePath,
                'status' => $status,
                'findings' => $findings,
            ];
        }
    }

    if ($rows === []) {
        $rows[] = [
            'consumer' => $consumerName,
            'path' => '(no visible twig pages)',
            'status' => 'no-visible-twig-surface-found',
            'findings' => ['No non-infrastructure Twig page found.'],
        ];
    }

    return $rows;
}

function normalizeRelativePath(string $root, string $path): string
{
    $root = rtrim(str_replace('\\', '/', $root), '/') . '/';
    $path = str_replace('\\', '/', $path);
    if (str_starts_with($path, $root)) {
        return substr($path, strlen($root));
    }

    return $path;
}

function isProviderInfrastructureTemplate(string $relativePath): bool
{
    foreach ([
        'template/interfacing/admin/body/mount.html.twig',
        'template/interfacing/admin/body/schema.html.twig',
        'template/interfacing/shell/',
        'template/base.html.twig',
        'templates/base.html.twig',
    ] as $allowed) {
        if ($relativePath === $allowed || str_starts_with($relativePath, $allowed)) {
            return true;
        }
    }

    return false;
}

/** @return list<string> */
function analyzeTemplate(string $relativePath, string $contents): array
{
    $findings = [];
    $isAdminLike = preg_match('/(crud|admin|workbench|table|form|detail|collection|dashboard|vendor|category|order|billing)/i', $relativePath . ' ' . $contents) === 1;

    if (!$isAdminLike) {
        return [];
    }

    $hasProviderMount = str_contains($contents, 'interfacing/admin/body/mount.html.twig')
        || str_contains($contents, 'data-interfacing-admin-body-mount')
        || str_contains($contents, 'data-admin-body-rendering-mode="canonical-provider-required"');

    if (!$hasProviderMount) {
        $findings[] = 'missing Interfacing admin body provider mount';
    }

    $hasLocalTable = str_contains($contents, '<table') || str_contains($contents, '<form');
    if ($hasLocalTable && !$hasProviderMount) {
        $findings[] = 'renders handmade Twig table/form instead of provider-owned body';
    }

    foreach ([
        '<style' => 'contains inline style; provider-rendered pages must not define handmade admin CSS',
        'btn btn-' => 'contains Bootstrap-like button class',
        'container-fluid' => 'contains Bootstrap-like container class',
        ' class="row"' => 'contains Bootstrap-like row class',
        'cruding_host_adapter' => 'contains removed Cruding-specific adapter marker',
        'templates/bundles/CrudingBundle' => 'contains removed HostApp copy/override surface marker',
    ] as $needle => $message) {
        if (str_contains($contents, $needle)) {
            $findings[] = $message;
        }
    }

    return $findings;
}

/** @param list<array{consumer:string,path:string,status:string,findings:list<string>}> $rows @param list<string> $errors */
function renderText(array $rows, array $errors): string
{
    $lines = [
        'Interfacing visible page provider adoption audit',
        '================================================',
    ];

    foreach ($errors as $error) {
        $lines[] = 'ERROR: ' . $error;
    }

    foreach ($rows as $row) {
        $lines[] = sprintf('%s | %s | %s', $row['consumer'], $row['path'], $row['status']);
        foreach ($row['findings'] as $finding) {
            $lines[] = '  - ' . $finding;
        }
    }

    return implode("\n", $lines) . "\n";
}

/** @param list<array{consumer:string,path:string,status:string,findings:list<string>}> $rows @param list<string> $errors */
function renderMarkdown(array $rows, array $errors): string
{
    $lines = [
        '# Interfacing visible page provider adoption audit',
        '',
        '| Consumer | Template | Status | Findings |',
        '| --- | --- | --- | --- |',
    ];

    foreach ($rows as $row) {
        $findings = $row['findings'] === [] ? '—' : implode('<br>', array_map('escapeMarkdownCell', $row['findings']));
        $lines[] = '| ' . escapeMarkdownCell($row['consumer']) . ' | `' . escapeMarkdownCell($row['path']) . '` | ' . escapeMarkdownCell($row['status']) . ' | ' . $findings . ' |';
    }

    if ($errors !== []) {
        $lines[] = '';
        $lines[] = '## Errors';
        foreach ($errors as $error) {
            $lines[] = '- ' . $error;
        }
    }

    return implode("\n", $lines) . "\n";
}

function escapeMarkdownCell(string $value): string
{
    return str_replace('|', '\\|', $value);
}

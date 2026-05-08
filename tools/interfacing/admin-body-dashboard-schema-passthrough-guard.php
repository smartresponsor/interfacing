<?php

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */

$root = dirname(__DIR__, 2);
$schemaPath = $root . '/template/interfacing/admin/body/schema.html.twig';
$mountPath = $root . '/template/interfacing/admin/body/mount.html.twig';

foreach ([$schemaPath, $mountPath] as $file) {
    if (!is_file($file)) {
        fwrite(STDERR, 'Missing Interfacing admin-body template: ' . $file . PHP_EOL);
        exit(1);
    }
}

$schema = file_get_contents($schemaPath);
foreach ([
    'dashboard: workbench.dashboard|default({})',
    'bridgeContext: workbench.bridgeContext|default({})',
    'resourceContract:',
    'runtime:',
] as $needle) {
    if (!str_contains($schema, $needle)) {
        fwrite(STDERR, 'Interfacing schema is missing dashboard passthrough marker: ' . $needle . PHP_EOL);
        exit(1);
    }
}

$dashboardPosition = strpos($schema, 'dashboard: workbench.dashboard|default({})');
$entrypointRuntimePosition = strpos($schema, "  runtime: {");
if (false === $dashboardPosition || false === $entrypointRuntimePosition || $dashboardPosition > $entrypointRuntimePosition) {
    fwrite(STDERR, 'Dashboard schema passthrough must be emitted before top-level runtime metadata.' . PHP_EOL);
    exit(1);
}

foreach (['crud-app-shell', '@Cruding/crud', 'Bootstrap', 'EasyAdmin'] as $forbidden) {
    if (str_contains($schema, $forbidden)) {
        fwrite(STDERR, 'Interfacing dashboard schema passthrough contains forbidden legacy UI marker: ' . $forbidden . PHP_EOL);
        exit(1);
    }
}

fwrite(STDOUT, "Interfacing admin-body dashboard schema passthrough guard passed.
");

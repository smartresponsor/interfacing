<?php

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */

$root = dirname(__DIR__, 2);

$files = [
    'template/interfacing/admin/body/schema.html.twig',
    'src/Contract/Ui/AdminBodyOperationPolicyContract.php',
    'public/interfacing/admin-body/canonical-providers.js',
];
foreach ($files as $file) {
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
    if (!is_file($path)) {
        fwrite(STDERR, "Missing dashboard renderer file: {$file}\n");
        exit(1);
    }
}

$schema = file_get_contents($root . '/template/interfacing/admin/body/schema.html.twig');
foreach ([
    "surface == 'dashboard' or operation == 'overview'",
    "'overview', 'index', 'show', 'new', 'edit', 'delete'",
    'dashboard: workbench.dashboard|default({}),',
    'bridgeContext: workbench.bridgeContext|default({}),',
] as $needle) {
    if (!str_contains($schema, $needle)) {
        fwrite(STDERR, "Dashboard schema passthrough/operation policy marker is missing: {$needle}\n");
        exit(1);
    }
}

$contract = file_get_contents($root . '/src/Contract/Ui/AdminBodyOperationPolicyContract.php');
if (!str_contains($contract, "public const OPERATION_OVERVIEW = 'overview';")) {
    fwrite(STDERR, "AdminBodyOperationPolicyContract must define OPERATION_OVERVIEW.\n");
    exit(1);
}

$bundle = file_get_contents($root . '/public/interfacing/admin-body/canonical-providers.js');
foreach ([
    'Dashboard sections',
    'Host panels',
    'e.surface === "dashboard" || t === "overview"',
] as $needle) {
    if (!str_contains($bundle, $needle)) {
        fwrite(STDERR, "Canonical provider bundle is missing dashboard renderer marker: {$needle}\n");
        exit(1);
    }
}

foreach (['crud-app-shell', 'data-cruding-shell-contract', '@Cruding/crud/index.html.twig'] as $forbidden) {
    if (str_contains($schema, $forbidden)) {
        fwrite(STDERR, "Dashboard schema contains forbidden legacy UI marker: {$forbidden}\n");
        exit(1);
    }
}

fwrite(STDOUT, "Interfacing admin body dashboard renderer guard passed.\n");

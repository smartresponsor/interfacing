<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

$root = dirname(__DIR__, 2);
$errors = [];
$required = [
    'src/Contract/Ui/AdminBodyBridgeProviderSurfaceContract.php',
    'src/Presentation/Controller/Interfacing/BridgeProviderSurfaceController.php',
    'template/interfacing/bridge/provider_surface.html.twig',
    'template/interfacing/admin/body/provider_document.html.twig',
    'docs/interfacing/interfacing-bridge-provider-surface.md',
    'public/interfacing/admin-body/runtime.js',
    'public/interfacing/admin-body/providers/antd-pro.js',
    'public/interfacing/admin-body/providers/primereact.js',
];

foreach ($required as $relative) {
    if (!is_file($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative))) {
        $errors[] = sprintf('Missing bridge provider surface file: %s', $relative);
    }
}

templateCheck($root, 'template/interfacing/bridge/provider_surface.html.twig', $errors);

$executor = readFileSafe($root, 'tools/interfacing/admin-body-consumer-provider-migration-executor.php');
if (!str_contains($executor, '--force-direct-template-rewrite')) {
    $errors[] = 'Consumer migration executor must require --force-direct-template-rewrite for direct template writes.';
}
if (str_contains($executor, 'Re-run with --apply to replace the template.')) {
    $errors[] = 'Consumer migration executor must not present --apply as the normal migration path.';
}

$docs = readFileSafe($root, 'docs/interfacing/interfacing-bridge-provider-surface.md')
    . readFileSafe($root, 'docs/interfacing/interfacing-consumer-provider-migration-executor.md')
    . readFileSafe($root, 'docs/MANIFEST.md')
    . readFileSafe($root, 'src/Contract/Ui/MANIFEST.md');
foreach (['Bridge owns route/resource adoption', 'Interfacing renders provider-owned UI', 'direct consumer template rewrite is not the primary path'] as $needle) {
    if (!str_contains($docs, $needle)) {
        $errors[] = sprintf('Bridge provider docs/manifests must contain: %s', $needle);
    }
}

if ($errors !== []) {
    echo "Interfacing bridge provider surface guard: FAILED\n";
    foreach ($errors as $error) {
        echo '- ' . $error . "\n";
    }
    exit(2);
}

echo "Interfacing bridge provider surface guard: OK\n";

function templateCheck(string $root, string $relative, array &$errors): void
{
    $content = readFileSafe($root, $relative);
    foreach (['<table', '<form', '<style', 'btn btn-', 'container-fluid', 'class="row"', "class='row'"] as $forbidden) {
        if (str_contains($content, $forbidden)) {
            $errors[] = sprintf('%s must not contain forbidden marker %s', $relative, $forbidden);
        }
    }
    foreach (['interfacing/admin/body/provider_document.html.twig', 'interfacing/admin/body/mount.html.twig', 'bridgeRows', 'bridgeColumns', "provider: 'antd-pro'", "secondaryProvider: 'primereact'"] as $required) {
        if (!str_contains($content, $required)) {
            $errors[] = sprintf('%s must contain %s', $relative, $required);
        }
    }
}

function readFileSafe(string $root, string $relative): string
{
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    if (!is_file($path)) {
        return '';
    }

    return (string) file_get_contents($path);
}

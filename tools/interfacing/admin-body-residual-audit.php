<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * Residual cleanup audit for the Interfacing admin body RC tail.
 *
 * Usage:
 *   php tools/interfacing/admin-body-residual-audit.php
 */
$root = dirname(__DIR__, 2);
$errors = [];

requireFile($root, 'src/Contract/Ui/AdminBodyResidualAuditContract.php', $errors);
requireFile($root, 'docs/interfacing/interfacing-admin-body-residual-audit-cleanup.md', $errors);
requireFile($root, 'tools/interfacing/admin-body-rc-guard.php', $errors);
requireFile($root, 'docs/interfacing/interfacing-admin-body-contract-index.md', $errors);
requireFile($root, 'docs/interfacing/interfacing-admin-body-consumer-guide.md', $errors);

$contract = readProjectFile($root, 'src/Contract/Ui/AdminBodyResidualAuditContract.php', $errors);
foreach ([
    "GUARD_ENTRYPOINT = 'tools/interfacing/admin-body-residual-audit.php'",
    "GUARD_WRAPPER = 'tools/interfacing/admin-body-residual-audit.ps1'",
    "FORBIDDEN_CRUDING_ADAPTER_TEMPLATE = 'template/interfacing/crud/bridge/cruding_host_adapter.html.twig'",
    "FORBIDDEN_HOST_COPY_PACK = 'pack/templates/bundles/CrudingBundle'",
    "FORBIDDEN_GET_RELATIVE_PATH = 'GetRelativePath'",
    'forbiddenPaths()',
    'requiredFiles()',
] as $needle) {
    requireContains($contract, $needle, 'Residual audit contract is missing marker: ' . $needle, $errors);
}

foreach ([
    'template/interfacing/crud/bridge/cruding_host_adapter.html.twig',
    'template/interfacing/crud/host_shell_adapter.html.twig',
    'pack/templates/bundles/CrudingBundle',
    'src/Contract/Crud/InterfacingCrudShellTemplateContract.php',
    'tools/interfacing/cruding-host-shell-pack-guard.php',
    'tools/interfacing/cruding-host-shell-pack-guard.ps1',
    'docs/interfacing/interfacing-cruding-bridge-adoption.md',
    'docs/interfacing/interfacing-cruding-host-override-pack.md',
    'docs/interfacing/interfacing-cruding-host-shell-pack-guard.md',
] as $relativePath) {
    forbidPathExists($root, $relativePath, 'Forbidden residual artifact still exists: ' . $relativePath, $errors);
}

$rcGuard = readProjectFile($root, 'tools/interfacing/admin-body-rc-guard.php', $errors);
foreach ([
    'admin-body-residual-audit.php',
    'Interfacing admin body residual audit',
] as $needle) {
    requireContains($rcGuard, $needle, 'RC guard must include residual audit marker: ' . $needle, $errors);
}

foreach ([
    'tools/interfacing/admin-body-rc-guard.ps1',
    'tools/interfacing/admin-body-residual-audit.ps1',
] as $wrapperPath) {
    $wrapper = readProjectFile($root, $wrapperPath, $errors);
    forbidContains($wrapper, 'GetRelativePath', $wrapperPath . ' must avoid System.IO.Path.GetRelativePath for Windows PowerShell compatibility.', $errors);
    forbidContains($wrapper, 'Resolve-RelativePathCompat', $wrapperPath . ' must not depend on relative-path helper functions.', $errors);
}

$index = readProjectFile($root, 'docs/interfacing/interfacing-admin-body-contract-index.md', $errors);
foreach ([
    'Residual audit',
    'admin-body-residual-audit.php',
    'No HostApp copy/override surface is the primary integration model.',
] as $needle) {
    requireContains($index, $needle, 'Contract index must include residual cleanup marker: ' . $needle, $errors);
}

$docs = readProjectFile($root, 'docs/interfacing/interfacing-admin-body-residual-audit-cleanup.md', $errors);
foreach ([
    'Residual audit',
    'admin-body-residual-audit.php',
    'admin-body-rc-guard.php',
    'no Cruding-specific adapter',
    'no HostApp copy surface',
    'no `GetRelativePath` dependency',
] as $needle) {
    requireContains($docs, $needle, 'Residual audit docs are missing marker: ' . $needle, $errors);
}

if ($errors !== []) {
    fwrite(STDERR, "Interfacing admin body residual audit: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    exit(2);
}

fwrite(STDOUT, "Interfacing admin body residual audit: OK\n");
exit(0);

/** @param list<string> $errors */
function requireFile(string $root, string $relativePath, array &$errors): void
{
    if (!is_file($root . '/' . $relativePath)) {
        $errors[] = 'Missing required file: ' . $relativePath;
    }
}

/** @param list<string> $errors */
function forbidPathExists(string $root, string $relativePath, string $message, array &$errors): void
{
    if (file_exists($root . '/' . $relativePath)) {
        $errors[] = $message;
    }
}

/** @param list<string> $errors */
function readProjectFile(string $root, string $relativePath, array &$errors): string
{
    $path = $root . '/' . $relativePath;
    if (!is_file($path)) {
        $errors[] = 'Missing required file: ' . $relativePath;
        return '';
    }

    return (string) file_get_contents($path);
}

/** @param list<string> $errors */
function requireContains(string $haystack, string $needle, string $message, array &$errors): void
{
    if (!str_contains($haystack, $needle)) {
        $errors[] = $message;
    }
}

/** @param list<string> $errors */
function forbidContains(string $haystack, string $needle, string $message, array &$errors): void
{
    if (str_contains($haystack, $needle)) {
        $errors[] = $message;
    }
}

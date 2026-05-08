<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * RC readiness gate for the Interfacing admin body contract.
 *
 * Usage:
 *   php tools/interfacing/admin-body-rc-readiness.php
 */
$root = dirname(__DIR__, 2);
$errors = [];

foreach ([
    'src/Contract/Ui/AdminBodyRcReadinessContract.php',
    'docs/interfacing/interfacing-admin-body-rc-readiness-gate.md',
    'tools/interfacing/admin-body-rc-guard.php',
    'tools/interfacing/admin-body-residual-audit.php',
    'tools/interfacing/admin-body-runtime-smoke.mjs',
    'docs/interfacing/interfacing-admin-body-contract-index.md',
    'docs/interfacing/interfacing-admin-body-consumer-guide.md',
    'tools/interfacing/admin-body-ui-provider-canon-guard.php',
    'tools/interfacing/admin-body-frontend-build-guard.php',
    'tools/interfacing/admin-body-consumer-provider-adoption-audit.php',
    'tools/interfacing/admin-body-consumer-provider-adoption-runner.php',
    'docs/interfacing/interfacing-admin-body-ui-provider-canon.md',
    'docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md',
    'tools/interfacing/admin-body-ecosystem-ui-coverage-audit.php',
    'tools/interfacing/admin-body-bridge-provider-surface-guard.php',
    'docs/interfacing/interfacing-bridge-provider-surface.md',
] as $relativePath) {
    requireFile($root, $relativePath, $errors);
}

$contract = readProjectFile($root, 'src/Contract/Ui/AdminBodyRcReadinessContract.php', $errors);
foreach ([
    "GATE_ENTRYPOINT = 'tools/interfacing/admin-body-rc-readiness.php'",
    "GATE_WRAPPER = 'tools/interfacing/admin-body-rc-readiness.ps1'",
    "CONTRACT_DOC = 'docs/interfacing/interfacing-admin-body-rc-readiness-gate.md'",
    "RC_MILESTONE = 'admin-body-rc1'",
    "CONSOLIDATED_GUARD = AdminBodyGuardConsolidationContract::CONSOLIDATED_GUARD_ENTRYPOINT",
    "RESIDUAL_AUDIT_GUARD = AdminBodyResidualAuditContract::GUARD_ENTRYPOINT",
    "RUNTIME_SMOKE_HARNESS = AdminBodyRuntimeSmokeContract::HARNESS_ENTRYPOINT",
    "DOCUMENTATION_INDEX = AdminBodyDocumentationContract::CONTRACT_INDEX_DOC",
    "UI_PROVIDER_CANON_GUARD = AdminBodyUiProviderCanonContract::GUARD_ENTRYPOINT",
    'readinessCriteria()',
    'commandPlan()',
] as $needle) {
    requireContains($contract, $needle, 'RC readiness contract is missing marker: ' . $needle, $errors);
}

$wrapper = readProjectFile($root, 'tools/interfacing/admin-body-rc-readiness.ps1', $errors);
requireContains($wrapper, 'admin-body-rc-readiness.php', 'RC readiness wrapper must call the PHP readiness gate.', $errors);
forbidContains($wrapper, 'GetRelativePath', 'RC readiness wrapper must avoid compatibility-sensitive relative path APIs.', $errors);
forbidContains($wrapper, 'Resolve-RelativePathCompat', 'RC readiness wrapper must avoid helper functions that can be missing at runtime.', $errors);

$docs = readProjectFile($root, 'docs/interfacing/interfacing-admin-body-rc-readiness-gate.md', $errors);
foreach ([
    'RC readiness gate',
    'admin-body-rc-readiness.php',
    'admin-body-rc-guard.php',
    'admin-body-rc1',
    'single ecosystem shell',
    'central admin body mount',
    'Ant Design ProComponents primary',
    'PrimeReact secondary',
    'UI provider canon',
    'frontend build hardening',
    'No HostApp copy surface',
    'No Cruding-specific adapter',
] as $needle) {
    requireContains($docs, $needle, 'RC readiness docs are missing marker: ' . $needle, $errors);
}

$index = readProjectFile($root, 'docs/interfacing/interfacing-admin-body-contract-index.md', $errors);
foreach ([
    'RC readiness gate',
    'admin-body-rc-readiness.php',
    'admin-body-rc1',
    'ui-provider-canon-present-and-guarded',
    'visible-page-provider-adoption-audit',
    'visible-page-provider-adoption-runner',
    'ecosystem-ecommerce-ui-coverage',
    'Bridge provider surface',
] as $needle) {
    requireContains($index, $needle, 'Contract index must mention the RC readiness gate: ' . $needle, $errors);
}

$manifest = readProjectFile($root, 'docs/MANIFEST.md', $errors);
requireContains($manifest, 'docs/interfacing/interfacing-admin-body-ui-provider-canon.md', 'Docs manifest must include the UI provider canon document.', $errors);
requireContains($manifest, 'docs/interfacing/interfacing-admin-body-rc-readiness-gate.md', 'Docs manifest must include the RC readiness gate document.', $errors);
requireContains($manifest, 'docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md', 'Docs manifest must include the ecosystem/e-commerce UI coverage document.', $errors);

if ($errors === []) {
    runCommand([PHP_BINARY, 'tools/interfacing/admin-body-rc-guard.php'], $root, $errors);
}

if ($errors !== []) {
    fwrite(STDERR, "Interfacing admin body RC readiness gate: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    exit(2);
}

fwrite(STDOUT, "Interfacing admin body RC readiness gate: OK\n");
exit(0);

/** @param list<string> $errors */
function requireFile(string $root, string $relativePath, array &$errors): void
{
    if (!is_file($root . '/' . $relativePath)) {
        $errors[] = 'Missing required file: ' . $relativePath;
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

/**
 * @param list<string> $command
 * @param list<string> $errors
 */
function runCommand(array $command, string $cwd, array &$errors): void
{
    $descriptorSpec = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ];

    $process = @proc_open($command, $descriptorSpec, $pipes, $cwd);
    if (!is_resource($process)) {
        $errors[] = 'Failed to start command: ' . implode(' ', $command);
        return;
    }

    fclose($pipes[0]);
    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    $exitCode = proc_close($process);
    if ($exitCode !== 0) {
        $errors[] = 'Command failed (' . $exitCode . '): ' . implode(' ', $command) . "\n" . trim((string) $stdout . "\n" . (string) $stderr);
    }
}

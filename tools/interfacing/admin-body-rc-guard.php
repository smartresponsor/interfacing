<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * Consolidated RC-facing guard for the Interfacing admin body contract.
 *
 * Usage:
 *   php tools/interfacing/admin-body-rc-guard.php
 */
$root = dirname(__DIR__, 2);
$errors = [];

requireFile($root, 'src/Contract/Ui/AdminBodyGuardConsolidationContract.php', $errors);
requireFile($root, 'docs/interfacing/interfacing-admin-body-guard-consolidation.md', $errors);
requireFile($root, 'tools/interfacing/admin-body-mount-contract-guard.php', $errors);
requireFile($root, 'tools/interfacing/single-ecosystem-base-guard.php', $errors);
requireFile($root, 'tools/interfacing/admin-body-runtime-smoke.mjs', $errors);
requireFile($root, 'tools/interfacing/admin-body-runtime-smoke.ps1', $errors);
requireFile($root, 'tools/interfacing/admin-body-residual-audit.php', $errors);
requireFile($root, 'tools/interfacing/admin-body-ui-provider-canon-guard.php', $errors);
requireFile($root, 'tools/interfacing/admin-body-frontend-build-guard.php', $errors);
requireFile($root, 'tools/interfacing/admin-body-consumer-provider-adoption-audit.php', $errors);
requireFile($root, 'tools/interfacing/admin-body-consumer-provider-adoption-runner.php', $errors);
requireFile($root, 'tools/interfacing/admin-body-ecosystem-ui-coverage-audit.php', $errors);
requireFile($root, 'tools/interfacing/admin-body-visible-page-provider-migration-guard.php', $errors);
requireFile($root, 'tools/interfacing/admin-body-bridge-provider-surface-guard.php', $errors);

$contract = readProjectFile($root, 'src/Contract/Ui/AdminBodyGuardConsolidationContract.php', $errors);
foreach ([
    "CONSOLIDATED_GUARD_ENTRYPOINT = 'tools/interfacing/admin-body-rc-guard.php'",
    "CONSOLIDATED_GUARD_WRAPPER = 'tools/interfacing/admin-body-rc-guard.ps1'",
    "ADMIN_BODY_STATIC_GUARD = 'tools/interfacing/admin-body-mount-contract-guard.php'",
    "SINGLE_ECOSYSTEM_BASE_GUARD = 'tools/interfacing/single-ecosystem-base-guard.php'",
    "RUNTIME_SMOKE_HARNESS = AdminBodyRuntimeSmokeContract::HARNESS_ENTRYPOINT",
    "FORBIDDEN_CRUDING_ADAPTER = 'cruding_host_adapter'",
    "FORBIDDEN_HOST_COPY_SURFACE = 'templates/bundles/CrudingBundle'",
    "FORBIDDEN_GET_RELATIVE_PATH = 'GetRelativePath'",
    "UI_PROVIDER_CANON_GUARD = AdminBodyUiProviderCanonContract::GUARD_ENTRYPOINT",
    'commandPlan()',
] as $needle) {
    requireContains($contract, $needle, 'Admin body guard consolidation contract is missing marker: ' . $needle, $errors);
}

$wrapper = readProjectFile($root, 'tools/interfacing/admin-body-rc-guard.ps1', $errors);
requireContains($wrapper, 'admin-body-rc-guard.php', 'Consolidated PowerShell wrapper must call the PHP RC guard.', $errors);
forbidContains($wrapper, 'GetRelativePath', 'Consolidated wrapper must avoid System.IO.Path.GetRelativePath for old PowerShell/.NET compatibility.', $errors);

$docs = readProjectFile($root, 'docs/interfacing/interfacing-admin-body-guard-consolidation.md', $errors);
foreach ([
    'admin-body-rc-guard.php',
    'admin-body-mount-contract-guard.php',
    'single-ecosystem-base-guard.php',
    'admin-body-runtime-smoke.mjs',
    'admin-body-residual-audit.php',
    'admin-body-ui-provider-canon-guard.php',
    'admin-body-frontend-build-guard.php',
    'admin-body-consumer-provider-adoption-audit.php',
    'admin-body-consumer-provider-adoption-runner.php',
    'admin-body-ecosystem-ui-coverage-audit.php',
    'admin-body-visible-page-provider-migration-guard.php',
    'admin-body-bridge-provider-surface-guard.php',
    'No HostApp copy surface',
    'No Cruding-specific adapter',
] as $needle) {
    requireContains($docs, $needle, 'Guard consolidation docs are missing marker: ' . $needle, $errors);
}

// The detailed lower-level guards own file-level forbidden-surface scans.
// Interfacing admin body residual audit closes removed adapter/copy artifacts before RC.
// This RC entrypoint keeps compatibility checks focused on the wrapper that
// operators execute directly.
if ($errors === []) {
    runCommand([$php = PHP_BINARY, 'tools/interfacing/admin-body-mount-contract-guard.php'], $root, $errors);
    runCommand([$php, 'tools/interfacing/single-ecosystem-base-guard.php'], $root, $errors);
    runCommand(['node', '--check', 'assets/interfacing/admin-body/runtime.js'], $root, $errors);
    runCommand(['node', '--check', 'tools/interfacing/admin-body-runtime-smoke.mjs'], $root, $errors);
    runCommand(['node', 'tools/interfacing/admin-body-runtime-smoke.mjs'], $root, $errors);
    runCommand([$php, 'tools/interfacing/admin-body-residual-audit.php'], $root, $errors);
    runCommand([$php, 'tools/interfacing/admin-body-ui-provider-canon-guard.php'], $root, $errors);
    runCommand([$php, 'tools/interfacing/admin-body-frontend-build-guard.php'], $root, $errors);
    runCommand([$php, 'tools/interfacing/admin-body-consumer-provider-adoption-audit.php'], $root, $errors);
    runCommand([$php, 'tools/interfacing/admin-body-consumer-provider-adoption-runner.php'], $root, $errors);
    runCommand([$php, 'tools/interfacing/admin-body-ecosystem-ui-coverage-audit.php'], $root, $errors);
    runCommand([$php, 'tools/interfacing/admin-body-visible-page-provider-migration-guard.php'], $root, $errors);
    runCommand([$php, 'tools/interfacing/admin-body-bridge-provider-surface-guard.php'], $root, $errors);
}

if ($errors !== []) {
    fwrite(STDERR, "Interfacing admin body RC guard: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    exit(2);
}

fwrite(STDOUT, "Interfacing admin body RC guard: OK\n");
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
 * @param list<string> $relativeDirectories
 * @param array<string,string> $forbidden
 * @param list<string> $errors
 */
function scanForbiddenText(string $root, array $relativeDirectories, array $forbidden, array &$errors): void
{
    foreach ($relativeDirectories as $relativeDirectory) {
        $directory = $root . '/' . $relativeDirectory;
        if (!is_dir($directory)) {
            continue;
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            if (!$file instanceof SplFileInfo || !$file->isFile()) {
                continue;
            }

            $path = $file->getPathname();
            $contents = (string) file_get_contents($path);
            $relativePath = str_replace($root . '/', '', str_replace('\\', '/', $path));
            foreach ($forbidden as $needle => $message) {
                if (str_contains($contents, $needle)) {
                    $errors[] = $message . ' File: ' . $relativePath;
                }
            }
        }
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

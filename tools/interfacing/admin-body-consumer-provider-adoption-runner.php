<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * Multi-consumer visible-page provider adoption runner.
 *
 * Usage:
 *   php tools/interfacing/admin-body-consumer-provider-adoption-runner.php
 *   php tools/interfacing/admin-body-consumer-provider-adoption-runner.php --consumer-root=../Cruding --strict
 *   php tools/interfacing/admin-body-consumer-provider-adoption-runner.php --defaults --format=markdown --output=var/provider-adoption.md
 */
$root = dirname(__DIR__, 2);
$options = parseRunnerOptions($argv);
$errors = [];

requireFile($root, 'src/Contract/Ui/AdminBodyConsumerProviderAdoptionRunnerContract.php', $errors);
requireFile($root, 'src/Contract/Ui/AdminBodyConsumerProviderAdoptionContract.php', $errors);
requireFile($root, 'tools/interfacing/admin-body-consumer-provider-adoption-audit.php', $errors);
requireFile($root, 'docs/interfacing/interfacing-visible-page-provider-adoption-runner.md', $errors);

$consumerRoots = $options['consumerRoots'];
if ($options['defaults']) {
    foreach (['../App', '../HostHub', '../Cruding', '../Vendoring'] as $defaultRoot) {
        if (!in_array($defaultRoot, $consumerRoots, true)) {
            $consumerRoots[] = $defaultRoot;
        }
    }
}

$reports = [];
$missing = [];
$failed = [];

foreach ($consumerRoots as $consumerRoot) {
    $absoluteConsumerRoot = resolveRunnerRoot($consumerRoot, $root);
    if (!is_dir($absoluteConsumerRoot)) {
        $missing[] = $consumerRoot;
        if ($options['requireExisting']) {
            $errors[] = 'Consumer root does not exist: ' . $consumerRoot;
        }
        continue;
    }

    $command = [
        PHP_BINARY,
        'tools/interfacing/admin-body-consumer-provider-adoption-audit.php',
        '--consumer-root=' . $consumerRoot,
        '--format=markdown',
    ];
    if ($options['strict']) {
        $command[] = '--strict';
    }

    $result = runRunnerCommand($command, $root);
    $reports[] = [
        'consumerRoot' => $consumerRoot,
        'exitCode' => $result['exitCode'],
        'stdout' => $result['stdout'],
        'stderr' => $result['stderr'],
    ];

    if ($result['exitCode'] !== 0) {
        $failed[] = $consumerRoot;
        if ($options['strict']) {
            $errors[] = 'Consumer adoption audit failed for ' . $consumerRoot . ': ' . trim($result['stderr'] . "\n" . $result['stdout']);
        }
    }
}

$report = $options['format'] === 'markdown'
    ? renderRunnerMarkdown($consumerRoots, $reports, $missing, $failed, $errors)
    : renderRunnerText($consumerRoots, $reports, $missing, $failed, $errors);

if ($options['output'] !== null) {
    $outputPath = resolveOutputPath($options['output'], $root);
    if (!is_dir(dirname($outputPath))) {
        mkdir(dirname($outputPath), 0777, true);
    }
    file_put_contents($outputPath, $report);
} else {
    fwrite(STDOUT, $report);
}

if ($errors !== []) {
    fwrite(STDERR, "Interfacing visible page provider adoption runner: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    exit(2);
}

fwrite(STDERR, "Interfacing visible page provider adoption runner: OK\n");
exit(0);

/** @return array{consumerRoots:list<string>,defaults:bool,strict:bool,requireExisting:bool,format:string,output:?string} */
function parseRunnerOptions(array $argv): array
{
    $consumerRoots = [];
    $defaults = false;
    $strict = false;
    $requireExisting = false;
    $format = 'text';
    $output = null;

    foreach (array_slice($argv, 1) as $argument) {
        if ($argument === '--defaults') {
            $defaults = true;
            continue;
        }
        if ($argument === '--strict') {
            $strict = true;
            continue;
        }
        if ($argument === '--require-existing') {
            $requireExisting = true;
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
        'defaults' => $defaults,
        'strict' => $strict,
        'requireExisting' => $requireExisting,
        'format' => $format,
        'output' => $output,
    ];
}

/** @param list<string> $errors */
function requireFile(string $root, string $relativePath, array &$errors): void
{
    if (!is_file($root . '/' . $relativePath)) {
        $errors[] = 'Missing required file: ' . $relativePath;
    }
}

function resolveRunnerRoot(string $consumerRoot, string $defaultRoot): string
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

function resolveOutputPath(string $outputPath, string $defaultRoot): string
{
    $normalized = str_replace('\\', '/', $outputPath);
    if (str_starts_with($normalized, '/') || preg_match('/^[A-Za-z]:\//', $normalized) === 1) {
        return $outputPath;
    }
    return $defaultRoot . '/' . $outputPath;
}

/** @param list<string> $command @return array{exitCode:int,stdout:string,stderr:string} */
function runRunnerCommand(array $command, string $cwd): array
{
    $descriptorSpec = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $process = @proc_open($command, $descriptorSpec, $pipes, $cwd);
    if (!is_resource($process)) {
        return ['exitCode' => 127, 'stdout' => '', 'stderr' => 'Failed to start command: ' . implode(' ', $command)];
    }

    fclose($pipes[0]);
    $stdout = (string) stream_get_contents($pipes[1]);
    $stderr = (string) stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $exitCode = proc_close($process);

    return ['exitCode' => $exitCode, 'stdout' => $stdout, 'stderr' => $stderr];
}

/** @param list<string> $consumerRoots @param list<array{consumerRoot:string,exitCode:int,stdout:string,stderr:string}> $reports @param list<string> $missing @param list<string> $failed @param list<string> $errors */
function renderRunnerText(array $consumerRoots, array $reports, array $missing, array $failed, array $errors): string
{
    $lines = [
        'Interfacing visible page provider adoption runner',
        '=================================================',
        'Consumer roots: ' . ($consumerRoots === [] ? '(none provided)' : implode(', ', $consumerRoots)),
    ];
    foreach ($missing as $root) {
        $lines[] = 'SKIPPED missing consumer root: ' . $root;
    }
    foreach ($reports as $report) {
        $lines[] = '';
        $lines[] = '## ' . $report['consumerRoot'] . ' [' . ($report['exitCode'] === 0 ? 'OK' : 'FAILED') . ']';
        $lines[] = trim($report['stdout']) !== '' ? trim($report['stdout']) : '(no stdout)';
        if (trim($report['stderr']) !== '') {
            $lines[] = 'stderr: ' . trim($report['stderr']);
        }
    }
    foreach ($errors as $error) {
        $lines[] = 'ERROR: ' . $error;
    }
    return implode("\n", $lines) . "\n";
}

/** @param list<string> $consumerRoots @param list<array{consumerRoot:string,exitCode:int,stdout:string,stderr:string}> $reports @param list<string> $missing @param list<string> $failed @param list<string> $errors */
function renderRunnerMarkdown(array $consumerRoots, array $reports, array $missing, array $failed, array $errors): string
{
    $lines = [
        '# Interfacing visible page provider adoption runner',
        '',
        'Consumer roots: ' . ($consumerRoots === [] ? '(none provided)' : implode(', ', array_map('escapeRunnerMarkdown', $consumerRoots))),
        '',
        '| Consumer root | Status | Notes |',
        '| --- | --- | --- |',
    ];
    foreach ($missing as $root) {
        $lines[] = '| `' . escapeRunnerMarkdown($root) . '` | skipped | consumer root not found |';
    }
    foreach ($reports as $report) {
        $status = $report['exitCode'] === 0 ? 'OK' : 'FAILED';
        $notes = trim($report['stderr']) !== '' ? trim($report['stderr']) : 'audit completed';
        $lines[] = '| `' . escapeRunnerMarkdown($report['consumerRoot']) . '` | ' . $status . ' | ' . escapeRunnerMarkdown($notes) . ' |';
    }
    foreach ($reports as $report) {
        $lines[] = '';
        $lines[] = '## ' . escapeRunnerMarkdown($report['consumerRoot']);
        $lines[] = '';
        $lines[] = trim($report['stdout']) !== '' ? trim($report['stdout']) : '_No output._';
    }
    if ($errors !== []) {
        $lines[] = '';
        $lines[] = '## Errors';
        foreach ($errors as $error) {
            $lines[] = '- ' . escapeRunnerMarkdown($error);
        }
    }
    return implode("\n", $lines) . "\n";
}

function escapeRunnerMarkdown(string $value): string
{
    return str_replace('|', '\\|', $value);
}

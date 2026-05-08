<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * Frontend dependency/build guard for strict provider-rendered admin body UI.
 */
$root = dirname(__DIR__, 2);
$errors = [];

foreach ([
    'src/Contract/Ui/AdminBodyFrontendBuildHardeningContract.php',
    'docs/interfacing/interfacing-admin-body-frontend-build-hardening.md',
    'package.json',
    '.interfacing/workspace/vite.config.ts',
    '.interfacing/workspace/tsconfig.json',
    '.interfacing/workspace/src/admin-body/main.tsx',
    '.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx',
    '.interfacing/workspace/src/admin-body/PrimeReactAdminBodyProvider.tsx',
] as $relativePath) {
    requireFile($root, $relativePath, $errors);
}

$contract = readProjectFile($root, 'src/Contract/Ui/AdminBodyFrontendBuildHardeningContract.php', $errors);
foreach ([
    "REACT_VERSION = '^18.3.1'",
    "REACT_DOM_VERSION = '^18.3.1'",
    'REACT_MAJOR = 18',
    "VITE_PUBLIC_DIR_SETTING = 'publicDir: false'",
    "VITE_EMPTY_OUT_DIR_SETTING = 'emptyOutDir: true'",
    "VITE_OUTPUT_FILE = 'public/interfacing/admin-body/canonical-providers.js'",
    'requiredDependencyVersions()',
] as $needle) {
    requireContains($contract, $needle, 'Frontend build hardening contract is missing marker: ' . $needle, $errors);
}

$package = json_decode(readProjectFile($root, 'package.json', $errors), true);
if (!is_array($package)) {
    $errors[] = 'package.json must be valid JSON.';
} else {
    requireSame($package['private'] ?? null, true, 'package.json must be private for the Interfacing provider workspace.', $errors);
    requireSame($package['type'] ?? null, 'module', 'package.json must keep ESM module mode for Vite provider sources.', $errors);

    $dependencies = is_array($package['dependencies'] ?? null) ? $package['dependencies'] : [];
    $devDependencies = is_array($package['devDependencies'] ?? null) ? $package['devDependencies'] : [];
    $allDependencies = array_merge($dependencies, $devDependencies);

    foreach ([
        'react' => '^18.3.1',
        'react-dom' => '^18.3.1',
        'antd' => '^5.26.7',
        '@ant-design/pro-components' => '^2.8.10',
        'primereact' => '^10.9.7',
        'primeicons' => '^7.0.0',
        'vite' => '^6.3.5',
        'typescript' => '^5.8.3',
        '@vitejs/plugin-react' => '^4.5.2',
    ] as $packageName => $expectedVersion) {
        requireSame($allDependencies[$packageName] ?? null, $expectedVersion, 'package.json must pin ' . $packageName . ' to ' . $expectedVersion, $errors);
    }

    foreach (['react', 'react-dom'] as $packageName) {
        $version = (string) ($dependencies[$packageName] ?? '');
        if (!preg_match('/\^18\./', $version)) {
            $errors[] = $packageName . ' must remain on the React 18 line; found: ' . ($version === '' ? '<missing>' : $version);
        }
    }

    foreach (['bootstrap', 'react-bootstrap', '@popperjs/core'] as $forbiddenPackage) {
        if (array_key_exists($forbiddenPackage, $allDependencies)) {
            $errors[] = 'Bootstrap-related package is forbidden in the Interfacing provider workspace: ' . $forbiddenPackage;
        }
    }

    foreach (['ui:build', 'ui:check', 'ui:audit'] as $scriptName) {
        if (!isset($package['scripts'][$scriptName])) {
            $errors[] = 'package.json must expose script: ' . $scriptName;
        }
    }
}

$vite = readProjectFile($root, '.interfacing/workspace/vite.config.ts', $errors);
foreach ([
    'publicDir: false',
    'emptyOutDir: true',
    "outDir: resolve(__dirname, '../../public/interfacing/admin-body')",
    "fileName: () => 'canonical-providers.js'",
] as $needle) {
    requireContains($vite, $needle, 'Vite config is missing build-hardening marker: ' . $needle, $errors);
}
forbidContains($vite, 'publicDir: true', 'Vite config must not enable Vite publicDir for Symfony public output.', $errors);
forbidContains($vite, 'emptyOutDir: false', 'Vite config must clean the canonical provider output directory.', $errors);

$docs = readProjectFile($root, 'docs/interfacing/interfacing-admin-body-frontend-build-hardening.md', $errors);
foreach ([
    'React 18',
    '`react`: `^18.3.1`',
    '`react-dom`: `^18.3.1`',
    'publicDir: false',
    'emptyOutDir: true',
    'npm run ui:build',
    'Do not run `npm audit fix --force`',
] as $needle) {
    requireContains($docs, $needle, 'Frontend build hardening docs are missing marker: ' . $needle, $errors);
}

if ($errors !== []) {
    fwrite(STDERR, "Interfacing admin body frontend build guard: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    exit(2);
}

fwrite(STDOUT, "Interfacing admin body frontend build guard: OK\n");
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

/** @param list<string> $errors */
function requireSame(mixed $actual, mixed $expected, string $message, array &$errors): void
{
    if ($actual !== $expected) {
        $errors[] = $message . ' Actual: ' . var_export($actual, true);
    }
}

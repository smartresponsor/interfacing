<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * UI provider canon guard for strict provider-required admin body rendering.
 */
$root = dirname(__DIR__, 2);
$errors = [];

foreach ([
    'src/Contract/Ui/AdminBodyUiProviderCanonContract.php',
    'docs/interfacing/interfacing-admin-body-ui-provider-canon.md',
    'docs/interfacing/interfacing-admin-body-frontend-build-hardening.md',
    'tools/interfacing/admin-body-frontend-build-guard.php',
    'package.json',
    '.interfacing/workspace/vite.config.ts',
    '.interfacing/workspace/tsconfig.json',
    '.interfacing/workspace/src/admin-body/main.tsx',
    '.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx',
    '.interfacing/workspace/src/admin-body/PrimeReactAdminBodyProvider.tsx',
    'template/interfacing/admin/body/mount.html.twig',
    'template/interfacing/admin/body/schema.html.twig',
    'assets/interfacing/admin-body/provider-registry.js',
    'assets/interfacing/admin-body/providers/antd-pro.js',
    'assets/interfacing/admin-body/providers/primereact.js',
    'assets/interfacing/admin-body/runtime.js',
    'docs/interfacing/interfacing-admin-body-contract-index.md',
    'docs/interfacing/interfacing-admin-body-consumer-guide.md',
    'assets/styles/app.css',
    'assets/app.js',
] as $relativePath) {
    requireFile($root, $relativePath, $errors);
}

$package = json_decode(readProjectFile($root, 'package.json', $errors), true);
if (!is_array($package)) {
    $errors[] = 'package.json must be valid JSON.';
} else {
    $dependencies = array_merge(
        is_array($package['dependencies'] ?? null) ? $package['dependencies'] : [],
        is_array($package['devDependencies'] ?? null) ? $package['devDependencies'] : []
    );

    foreach (['antd', '@ant-design/pro-components', 'primereact', 'primeicons', 'react', 'react-dom', 'vite', 'typescript', '@vitejs/plugin-react'] as $packageName) {
        if (!array_key_exists($packageName, $dependencies)) {
            $errors[] = 'package.json must expose canonical frontend provider/build package: ' . $packageName;
        }
    }

    foreach (['react' => '^18.3.1', 'react-dom' => '^18.3.1'] as $packageName => $expectedVersion) {
        if (($dependencies[$packageName] ?? null) !== $expectedVersion) {
            $errors[] = 'React dependency line must be canonical and provider-compatible: ' . $packageName . ' = ' . $expectedVersion;
        }
    }

    foreach (['bootstrap', 'react-bootstrap', '@popperjs/core'] as $forbiddenPackage) {
        if (array_key_exists($forbiddenPackage, $dependencies)) {
            $errors[] = 'Bootstrap-related package is not part of the Interfacing UI provider canon: ' . $forbiddenPackage;
        }
    }
}

$composerPath = $root . '/composer.json';
$composer = is_file($composerPath) ? json_decode((string) file_get_contents($composerPath), true) : null;
if (is_array($composer)) {
    $composerRequire = array_merge(
        is_array($composer['require'] ?? null) ? $composer['require'] : [],
        is_array($composer['require-dev'] ?? null) ? $composer['require-dev'] : []
    );
    foreach (['twbs/bootstrap', 'symfony/webpack-encore-bundle'] as $forbiddenPackage) {
        if (array_key_exists($forbiddenPackage, $composerRequire)) {
            $errors[] = 'Composer must not install or imply a Bootstrap admin body provider: ' . $forbiddenPackage;
        }
    }
}

$contract = readProjectFile($root, 'src/Contract/Ui/AdminBodyUiProviderCanonContract.php', $errors);
foreach ([
    "PRIMARY_PROVIDER = 'antd-pro'",
    "PRIMARY_PACKAGE = '@ant-design/pro-components'",
    "PRIMARY_LIBRARY = 'antd'",
    "SECONDARY_PROVIDER = 'primereact'",
    "SECONDARY_PACKAGE = 'primereact'",
    "FORBIDDEN_PROVIDER_ASSUMPTION_BOOTSTRAP = 'bootstrap'",
    "FORBIDDEN_ADMIN_TWIG_DESIGN_SYSTEM = 'handmade-twig-css-admin-body'",
] as $needle) {
    requireContains($contract, $needle, 'UI provider canon contract is missing marker: ' . $needle, $errors);
}

$docs = readProjectFile($root, 'docs/interfacing/interfacing-admin-body-ui-provider-canon.md', $errors);
foreach ([
    'Ant Design + ProComponents',
    'PrimeReact',
    'not a Bootstrap',
    'Do not introduce Bootstrap',
    'Do not hardcode a new admin UI design system in Twig/CSS',
    'canonical-provider-required',
    'npm run ui:build',
    'React 18',
] as $needle) {
    requireContains($docs, $needle, 'UI provider canon docs are missing marker: ' . $needle, $errors);
}
foreach (['fallback', 'Fallback', 'provider-less UI'] as $needle) {
    forbidContains($docs, $needle, 'UI provider canon docs must not preserve fallback wording: ' . $needle, $errors);
}

$mount = readProjectFile($root, 'template/interfacing/admin/body/mount.html.twig', $errors);
foreach ([
    'data-admin-body-rendering-mode="canonical-provider-required"',
    'data-admin-body-contract="ant-design-procomponents"',
    'data-admin-body-canonical-provider-bundle="interfacing/admin-body/canonical-providers.js"',
    'data-admin-body-antd-pro-provider-entrypoint',
    'data-admin-body-primereact-provider-entrypoint',
] as $needle) {
    requireContains($mount, $needle, 'Admin body mount must expose provider canon marker: ' . $needle, $errors);
}
foreach (['btn btn-', 'container-fluid', ' class="row"', ' col-', '<style', 'fallback'] as $needle) {
    forbidContains($mount, $needle, 'Admin body mount must not use Bootstrap/fallback marker: ' . $needle, $errors);
}

$antdProvider = readProjectFile($root, '.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx', $errors);
foreach (['PageContainer', 'ProTable', 'ProForm', '@ant-design/pro-components', 'antd'] as $needle) {
    requireContains($antdProvider, $needle, 'AntD Pro provider source is missing marker: ' . $needle, $errors);
}


$appCss = readProjectFile($root, 'assets/styles/app.css', $errors);
foreach (['skyblue', 'btn btn-', 'container-fluid', ' class="row"', '.if-table', '.if-card'] as $needle) {
    forbidContains($appCss, $needle, 'Application CSS must not preserve handmade/Bootstrap-like admin styling marker: ' . $needle, $errors);
}
$appJs = readProjectFile($root, 'assets/app.js', $errors);
forbidContains($appJs, 'welcome to AssetMapper', 'Application JS must not preserve Symfony scaffold console noise.', $errors);

$primeProvider = readProjectFile($root, '.interfacing/workspace/src/admin-body/PrimeReactAdminBodyProvider.tsx', $errors);
requireContains($primeProvider, 'primereact', 'PrimeReact provider source must preserve the secondary provider marker.', $errors);

if ($errors !== []) {
    fwrite(STDERR, "Interfacing admin body UI provider canon guard: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    exit(2);
}

fwrite(STDOUT, "Interfacing admin body UI provider canon guard: OK\n");
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

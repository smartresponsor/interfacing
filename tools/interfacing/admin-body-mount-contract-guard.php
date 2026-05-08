<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * Strict admin body mount guard.
 *
 * The admin body must be rendered by canonical frontend providers. Twig may
 * publish mount/schema/script wiring only; it must not render fallback tables,
 * fallback forms, Bootstrap-style classes, or inline admin CSS.
 */
$root = dirname(__DIR__, 2);
$errors = [];

$requiredFiles = [
    'src/Contract/Ui/AdminBodyMountContract.php',
    'src/Contract/Ui/AdminBodyRuntimeContract.php',
    'src/Contract/Ui/AdminBodySchemaContract.php',
    'src/Contract/Ui/AdminBodyUiProviderCanonContract.php',
    'template/interfacing/admin/body/mount.html.twig',
    'template/interfacing/admin/body/schema.html.twig',
    'template/interfacing/crud/screen.html.twig',
    'template/interfacing/crud/workbench_base.html.twig',
    'assets/interfacing/admin-body/provider-registry.js',
    'assets/interfacing/admin-body/providers/antd-pro.js',
    'assets/interfacing/admin-body/providers/primereact.js',
    'assets/interfacing/admin-body/runtime.js',
    '.interfacing/workspace/vite.config.ts',
    '.interfacing/workspace/tsconfig.json',
    '.interfacing/workspace/src/admin-body/main.tsx',
    '.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx',
    '.interfacing/workspace/src/admin-body/PrimeReactAdminBodyProvider.tsx',
];

foreach ($requiredFiles as $relativePath) {
    requireFile($root, $relativePath, $errors);
}

$mount = readProjectFile($root, 'template/interfacing/admin/body/mount.html.twig', $errors);
foreach ([
    'data-admin-body-rendering-mode="canonical-provider-required"',
    'data-admin-body-contract="ant-design-procomponents"',
    'data-admin-body-canonical-provider-bundle="interfacing/admin-body/canonical-providers.js"',
    'data-admin-body-antd-pro-provider-entrypoint="interfacing/admin-body/providers/antd-pro.js"',
    'data-admin-body-primereact-provider-entrypoint="interfacing/admin-body/providers/primereact.js"',
    'data-accessibility-mode="provider-native-required"',
    "asset('interfacing/admin-body/canonical-providers.js')",
    "asset('interfacing/admin-body/runtime.js')",
] as $needle) {
    requireContains($mount, $needle, 'Admin body mount is missing strict provider marker: ' . $needle, $errors);
}

foreach ([
    '<style',
    'data-admin-body-fallback',
    'admin_body_table_fallback',
    'admin_body_cards_fallback',
    'admin_body_form_fallback',
    'Twig fallback',
    'fallback table',
    'fallback form',
    'btn btn-',
    'container-fluid',
    ' class="row"',
    ' col-',
] as $needle) {
    forbidContains($mount, $needle, 'Admin body mount must not expose provider-less UI marker: ' . $needle, $errors);
}

$screen = readProjectFile($root, 'template/interfacing/crud/screen.html.twig', $errors);
foreach ([
    "include 'interfacing/admin/body/mount.html.twig'",
    "provider: 'antd-pro'",
    "secondaryProvider: 'primereact'",
] as $needle) {
    requireContains($screen, $needle, 'CRUD screen must enter the strict admin body mount: ' . $needle, $errors);
}
foreach (['embed \'interfacing/admin/body/mount.html.twig\'', 'admin_body_table_fallback', 'interfacing/crud/mode/', '<table', '<form'] as $needle) {
    forbidContains($screen, $needle, 'CRUD screen must not render native admin body UI: ' . $needle, $errors);
}

$workbenchBase = readProjectFile($root, 'template/interfacing/crud/workbench_base.html.twig', $errors);
foreach (['<style', '.if-table', '.if-card', '.if-button', 'fallback UI'] as $needle) {
    forbidContains($workbenchBase, $needle, 'CRUD workbench base must not contain inline/provider-less admin UI CSS: ' . $needle, $errors);
}

$schema = readProjectFile($root, 'template/interfacing/admin/body/schema.html.twig', $errors);
foreach ([
    "requireCanonicalProviders: true",
    "replacementMode: secondaryReplacementMode|default('forbidden-for-admin-body')",
    "providerRequiredErrorEvent: 'interfacing:admin-body:provider-required-error'",
    "providerPolicy: 'canonical-provider-required'",
    "secondaryProviderReplacement: 'forbidden-for-admin-body'",
    "mode: 'provider-native-required'",
    "primaryAdminWorkbench: 'ant-design-procomponents'",
    "secondaryRichFacade: 'primereact'",
] as $needle) {
    requireContains($schema, $needle, 'Admin body schema must expose strict provider marker: ' . $needle, $errors);
}
foreach (["'fallback'", 'fallback:', 'fallbackPolicy', 'keepTwigFallback', 'primary-provider-missing', 'disabled-for-admin-body', 'provider-native-with-twig-fallback'] as $needle) {
    forbidContains($schema, $needle, 'Admin body schema must not expose fallback/degraded provider policy: ' . $needle, $errors);
}

$runtime = readProjectFile($root, 'assets/interfacing/admin-body/runtime.js', $errors);
foreach ([
    "const PROVIDER_REQUIRED_ERROR_EVENT = 'interfacing:admin-body:provider-required-error'",
    "const FORBIDDEN_SECONDARY_REPLACEMENT = 'forbidden-for-admin-body'",
    "mount.dataset[HYDRATION_ATTR] = providerName ? 'provider-required-error' : 'provider-policy-error'",
    'provider.mount(mount, schema)',
] as $needle) {
    requireContains($runtime, $needle, 'Runtime must enforce strict provider rendering: ' . $needle, $errors);
}
foreach (['primary-provider-missing', 'DISABLED_SECONDARY_FALLBACK', 'keep-twig-fallback', 'fallback visible', 'Twig fallback'] as $needle) {
    forbidContains($runtime, $needle, 'Runtime must not keep legacy fallback behavior: ' . $needle, $errors);
}

$workspaceProvider = readProjectFile($root, '.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx', $errors);
foreach (['@ant-design/pro-components', 'ProTable', 'ProForm', 'PageContainer', 'antd'] as $needle) {
    requireContains($workspaceProvider, $needle, 'AntD Pro provider source is missing canonical provider marker: ' . $needle, $errors);
}

if ($errors !== []) {
    fwrite(STDERR, "Interfacing admin body mount contract guard: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    exit(2);
}

fwrite(STDOUT, "Interfacing admin body mount contract guard: OK\n");
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

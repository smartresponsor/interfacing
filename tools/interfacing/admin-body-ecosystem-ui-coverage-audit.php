<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

$root = dirname(__DIR__, 2);
$errors = [];

foreach ([
    'src/Contract/Ui/AdminBodyEcommerceUiCoverageContract.php',
    'docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md',
    'package.json',
    '.interfacing/workspace/vite.config.ts',
    '.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx',
    '.interfacing/workspace/src/admin-body/PrimeReactAdminBodyProvider.tsx',
    '.interfacing/workspace/src/admin-body/main.tsx',
    'assets/styles/app.css',
    'assets/app.js',
] as $relativePath) {
    requireFile($root, $relativePath, $errors);
}

$contract = readProjectFile($root, 'src/Contract/Ui/AdminBodyEcommerceUiCoverageContract.php', $errors);
foreach ([
    'canonicalComponents()',
    'ecommercePageFamilies()',
    'componentPageCoverage()',
    "'Cruding'",
    "'Cataloging'",
    "'Ordering'",
    "'Paying'",
    "'Shipping'",
    "'Taxating'",
    "'Currencing'",
    "'Messaging'",
    "'public-storefront'",
    "'cart-checkout'",
] as $needle) {
    requireContains($contract, $needle, 'E-commerce UI coverage contract is missing marker: ' . $needle, $errors);
}

$docs = readProjectFile($root, 'docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md', $errors);
foreach ([
    'Ant Design + ProComponents',
    'PrimeReact',
    'No Bootstrap direction',
    'Canonical component map',
    'E-commerce page families',
    'Cruding',
    'Cataloging',
    'Ordering',
    'Paying',
    'Shipping',
    'Taxating',
    'Currencing',
    'public storefront',
    'cart/checkout',
] as $needle) {
    requireContains($docs, $needle, 'E-commerce UI coverage docs are missing marker: ' . $needle, $errors);
}

$package = json_decode(readProjectFile($root, 'package.json', $errors), true);
if (!is_array($package)) {
    $errors[] = 'package.json must be valid JSON.';
} else {
    $deps = array_merge(
        is_array($package['dependencies'] ?? null) ? $package['dependencies'] : [],
        is_array($package['devDependencies'] ?? null) ? $package['devDependencies'] : []
    );
    foreach (['antd', '@ant-design/pro-components', 'primereact', 'primeicons', 'react', 'react-dom', 'vite', 'typescript', '@vitejs/plugin-react'] as $dependency) {
        if (!array_key_exists($dependency, $deps)) {
            $errors[] = 'Missing canonical provider dependency in package.json: ' . $dependency;
        }
    }
}

$antd = readProjectFile($root, '.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx', $errors);
foreach (['PageContainer', 'ProTable', 'ProForm', '@ant-design/pro-components', 'antd/dist/reset.css'] as $needle) {
    requireContains($antd, $needle, 'AntD provider implementation is missing marker: ' . $needle, $errors);
}

$prime = readProjectFile($root, '.interfacing/workspace/src/admin-body/PrimeReactAdminBodyProvider.tsx', $errors);
foreach (['PrimeReactProvider', 'primeicons/primeicons.css', 'secondary-rich-facade'] as $needle) {
    requireContains($prime, $needle, 'PrimeReact provider implementation is missing marker: ' . $needle, $errors);
}

$appCss = readProjectFile($root, 'assets/styles/app.css', $errors);
foreach (['skyblue', 'btn btn-', 'container-fluid', ' class="row"', '.if-table', '.if-card'] as $needle) {
    forbidContains($appCss, $needle, 'Application CSS must not preserve handmade/Bootstrap-like admin styling marker: ' . $needle, $errors);
}

$appJs = readProjectFile($root, 'assets/app.js', $errors);
forbidContains($appJs, 'welcome to AssetMapper', 'Application JS must not preserve Symfony scaffold console noise.', $errors);

if ($errors !== []) {
    fwrite(STDERR, "Interfacing ecosystem/e-commerce UI coverage audit: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    exit(2);
}

fwrite(STDOUT, "Interfacing ecosystem/e-commerce UI coverage audit: OK\n");
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

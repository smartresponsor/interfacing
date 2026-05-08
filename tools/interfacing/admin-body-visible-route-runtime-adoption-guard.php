<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

$root = dirname(__DIR__, 2);
$errors = [];

$controller = readFileSafe($root, 'src/Presentation/Controller/Interfacing/BridgeProviderSurfaceController.php');
$routes = readFileSafe($root, 'config/routes/interfacing_attributes.yaml');
$genericBridge = readFileSafe($root, 'config/routes/zz_interfacing_crud_bridge.yaml');
$mount = readFileSafe($root, 'template/interfacing/admin/body/mount.html.twig');
$surface = readFileSafe($root, 'template/interfacing/bridge/provider_surface.html.twig');
$controllerIndex = readFileSafe($root, 'src/Presentation/Controller/Interfacing/InterfacingController.php');
$shellChrome = readFileSafe($root, 'src/Service/Interfacing/Shell/ShellChromeProvider.php');

foreach ([
    'src/Presentation/Controller/Interfacing/BridgeProviderSurfaceController.php',
    'config/routes/interfacing_attributes.yaml',
    'config/routes/zz_interfacing_crud_bridge.yaml',
    'template/interfacing/admin/body/mount.html.twig',
    'template/interfacing/bridge/provider_surface.html.twig',
    'template/interfacing/admin/body/provider_document.html.twig',
    'public/interfacing/admin-body/provider-registry.js',
    'public/interfacing/admin-body/providers/antd-pro.js',
    'public/interfacing/admin-body/providers/primereact.js',
    'public/interfacing/admin-body/runtime.js',
    'public/interfacing/admin-body/canonical-providers.js',
    'public/interfacing/admin-body/canonical-providers.interfacing-interface-ui.css',
] as $relative) {
    if (!is_file(pathOf($root, $relative))) {
        $errors[] = sprintf('Missing runtime adoption file: %s', $relative);
    }
}

if (!str_contains($routes, 'BridgeProviderSurfaceController.php')) {
    $errors[] = 'BridgeProviderSurfaceController must be imported by config/routes/interfacing_attributes.yaml.';
}

foreach (['catalog', 'category', 'product', 'collection', 'attribute', 'crud', 'cruding', 'vendor', 'vendoring'] as $visibleRoot) {
    if (!str_contains($controller, $visibleRoot)) {
        $errors[] = sprintf('BridgeProviderSurfaceController must explicitly adopt visible root: %s', $visibleRoot);
    }

    if (!str_contains($genericBridge, $visibleRoot)) {
        $errors[] = sprintf('Generic CRUD bridge route requirements must exclude visible provider root: %s', $visibleRoot);
    }
}

foreach (['interfacing_bridge_visible_provider_surface', 'normalizeVisiblePath', 'seedRows', 'columnsFor', 'formFieldsFor'] as $needle) {
    if (!str_contains($controller, $needle)) {
        $errors[] = sprintf('Bridge provider surface controller must contain runtime adoption member: %s', $needle);
    }
}

foreach (['canonical-providers.interfacing-interface-ui.css', 'provider-registry.js', 'canonical-providers.js', 'providers/antd-pro.js', 'providers/primereact.js', 'runtime.js'] as $asset) {
    if (!str_contains($mount, $asset)) {
        $errors[] = sprintf('Admin body mount must wire browser asset: %s', $asset);
    }
}

foreach (['provider_document.html.twig', 'bridgeRows', 'bridgeColumns', 'bridgeFilters', 'bridgeFormFields', "provider: 'antd-pro'", "secondaryProvider: 'primereact'"] as $needle) {
    if (!str_contains($surface, $needle)) {
        $errors[] = sprintf('Bridge provider surface template must pass provider workbench payload: %s', $needle);
    }
}


foreach (['?v=w44-provider-visible-adoption', 'provider.catalog', '/catalog/category/', '/catalog/product/'] as $needle) {
    if (!str_contains($mount . $controllerIndex . $shellChrome, $needle)) {
        $errors[] = sprintf('Visible provider adoption must contain browser-visible wiring marker: %s', $needle);
    }
}

foreach (["'/category/'", '"/category/"'] as $forbiddenLink) {
    if (str_contains($shellChrome, $forbiddenLink)) {
        $errors[] = sprintf('Shell chrome must not keep old catalog consumer link: %s', $forbiddenLink);
    }
}

$providerDocument = readFileSafe($root, 'template/interfacing/admin/body/provider_document.html.twig');
foreach (['data-interfacing-provider-document', 'ant-design-procomponents', 'primereact', 'canonical-providers.interfacing-interface-ui.css'] as $needle) {
    if (!str_contains($providerDocument, $needle)) {
        $errors[] = sprintf('Provider document must contain provider-only document marker: %s', $needle);
    }
}
foreach (['interfacing/shell/base.html.twig', 'btn btn-', 'container-fluid', '<table', '<form', '<style'] as $forbidden) {
    if (str_contains($providerDocument, $forbidden)) {
        $errors[] = sprintf('Provider document must not contain forbidden legacy/shell marker: %s', $forbidden);
    }
}

foreach (['GenericCrudWorkbenchController::show', 'btn btn-', 'container-fluid', '<table', '<form', '<style'] as $forbidden) {
    if (str_contains($surface, $forbidden)) {
        $errors[] = sprintf('Bridge provider surface template must not contain forbidden marker: %s', $forbidden);
    }
}

if ($errors !== []) {
    echo "Interfacing visible route runtime adoption guard: FAILED\n";
    foreach ($errors as $error) {
        echo '- ' . $error . "\n";
    }
    exit(2);
}

echo "Interfacing visible route runtime adoption guard: OK\n";

function pathOf(string $root, string $relative): string
{
    return $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
}

function readFileSafe(string $root, string $relative): string
{
    $path = pathOf($root, $relative);
    if (!is_file($path)) {
        return '';
    }

    return (string) file_get_contents($path);
}

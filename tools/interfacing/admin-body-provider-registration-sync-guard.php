<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$checks = [
    'template/interfacing/admin/body/mount.html.twig' => [
        'process-env.js?v=w52-provider-registration-sync',
        'provider-registry.js?v=w52-provider-registration-sync',
        'canonical-providers.js?v=w52-provider-registration-sync',
        'runtime.js?v=w52-provider-registration-sync',
    ],
    'template/interfacing/admin/body/provider_document.html.twig' => [
        'w52-provider-registration-sync',
    ],
    'public/interfacing/admin-body/process-env.js' => [
        'globalThis.process',
        'NODE_ENV',
    ],
    'public/interfacing/admin-body/provider-registry.js' => [
        'interfacing:admin-body:provider-registry-ready',
        'PROVIDER_REGISTRY_READY_EVENT',
    ],
    'public/interfacing/admin-body/providers/antd-pro.js' => [
        'provider-registry-ready',
        'deferred-turn-3',
        'attachAntDesignProProvider',
    ],
    'public/interfacing/admin-body/runtime.js' => [
        'registerCanonicalProviderFallback',
        'provider-registry-ready',
        'window.setTimeout(boot, 150)',
    ],
    'public/interfacing/admin-body/canonical-providers.js' => [
        'dashboard.metrics',
        'dashboard.sections',
        'dashboard.sidePanels',
        'InterfacingAntDesignProAdminBodyProvider',
    ],
];

foreach ($checks as $relative => $needles) {
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    if (!is_file($path)) {
        fwrite(STDERR, "Missing required file: {$relative}\n");
        exit(1);
    }
    $body = file_get_contents($path);
    foreach ($needles as $needle) {
        if (!str_contains($body, $needle)) {
            fwrite(STDERR, "{$relative} is missing marker: {$needle}\n");
            exit(1);
        }
    }
}

echo "Interfacing admin body provider registration sync guard passed.\n";

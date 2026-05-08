<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$mount = $root . '/template/interfacing/admin/body/mount.html.twig';
$document = $root . '/template/interfacing/admin/body/provider_document.html.twig';
$bundle = $root . '/public/interfacing/admin-body/canonical-providers.js';
$css = $root . '/public/interfacing/admin-body/canonical-providers.interfacing-interface-ui.css';
$doc = $root . '/docs/interfacing/interfacing-admin-body-dashboard-panel-renderer-sync.md';
foreach ([$mount, $document, $bundle, $css, $doc] as $file) {
    if (!is_file($file)) {
        fwrite(STDERR, "Missing required dashboard panel renderer sync file: {$file}\n");
        exit(1);
    }
}
$mountContent = file_get_contents($mount) ?: '';
$documentContent = file_get_contents($document) ?: '';
$bundleContent = file_get_contents($bundle) ?: '';
foreach (['process-env.js', 'provider-registry.js', 'canonical-providers.js', 'providers/antd-pro.js', 'providers/primereact.js', 'runtime.js'] as $asset) {
    $needle = $asset . '?v=w51-dashboard-panel-renderer-sync';
    if (!str_contains($mountContent, $needle)) {
        fwrite(STDERR, "Admin body mount must load {$needle}.\n");
        exit(1);
    }
}
if (!str_contains($documentContent, 'canonical-providers.interfacing-interface-ui.css') || !str_contains($documentContent, '?v=w51-dashboard-panel-renderer-sync')) {
    fwrite(STDERR, "Provider document must use the dashboard panel renderer cache-busted stylesheet.\n");
    exit(1);
}
foreach (['App host Wave 07 dashboard panels renderer.', 'e.surface === "dashboard" || t === "overview"', 'sidePanels', 'dashboard', 'metrics', 'widgets'] as $marker) {
    if (!str_contains($bundleContent, $marker)) {
        fwrite(STDERR, "canonical-providers.js is missing dashboard panel renderer marker: {$marker}\n");
        exit(1);
    }
}
if (str_contains($mountContent, '?v=w47-browser-process-shim') || str_contains($documentContent, '?v=w47-browser-process-shim')) {
    fwrite(STDERR, "Dashboard mount still references stale w47 assets.\n");
    exit(1);
}
fwrite(STDOUT, "Interfacing dashboard panel renderer sync guard passed.\n");

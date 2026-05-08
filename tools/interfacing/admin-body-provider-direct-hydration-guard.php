<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$runtime = $root . '/public/interfacing/admin-body/runtime.js';
$registry = $root . '/public/interfacing/admin-body/provider-registry.js';
$antd = $root . '/public/interfacing/admin-body/providers/antd-pro.js';
$mount = $root . '/template/interfacing/admin/body/mount.html.twig';
$processEnv = $root . '/public/interfacing/admin-body/process-env.js';

$checks = [
    [$runtime, 'ensurePrimaryProviderRegistration'],
    [$runtime, 'directRegisterExternalProvider'],
    [$runtime, 'InterfacingAntDesignProAdminBodyProvider'],
    [$runtime, 'provider-registry-ready'],
    [$registry, 'provider-registry-ready'],
    [$antd, 'provider-registry-ready'],
    [$mount, 'w53-provider-direct-hydration'],
    [$processEnv, 'globalThis.process'],
];

foreach ($checks as [$file, $needle]) {
    if (!is_file($file)) {
        fwrite(STDERR, "Missing required file: {$file}\n");
        exit(1);
    }

    $contents = (string) file_get_contents($file);
    if (!str_contains($contents, $needle)) {
        fwrite(STDERR, "Required marker {$needle} missing in {$file}\n");
        exit(1);
    }
}

$mountContents = (string) file_get_contents($mount);
$processPos = strpos($mountContents, 'process-env.js');
$canonicalPos = strpos($mountContents, 'canonical-providers.js');
if ($processPos === false || $canonicalPos === false || $processPos > $canonicalPos) {
    fwrite(STDERR, "process-env.js must be loaded before canonical-providers.js in admin body mount.\n");
    exit(1);
}

echo "Interfacing provider direct hydration guard passed.\n";

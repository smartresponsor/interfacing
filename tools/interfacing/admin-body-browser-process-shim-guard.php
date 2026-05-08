<?php
// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$processShim = $root . '/public/interfacing/admin-body/process-env.js';
$mount = $root . '/template/interfacing/admin/body/mount.html.twig';
$document = $root . '/template/interfacing/admin/body/provider_document.html.twig';

foreach ([$processShim, $mount, $document] as $path) {
    if (!is_file($path)) {
        fwrite(STDERR, sprintf("Missing required admin-body browser process shim file: %s
", $path));
        exit(1);
    }
}

$shim = file_get_contents($processShim) ?: '';
foreach (['global.process', 'NODE_ENV', 'production'] as $required) {
    if (!str_contains($shim, $required)) {
        fwrite(STDERR, sprintf("process-env.js is missing required marker: %s
", $required));
        exit(1);
    }
}

$mountBody = file_get_contents($mount) ?: '';
$processPosition = strpos($mountBody, 'process-env.js');
$canonicalPosition = strpos($mountBody, 'canonical-providers.js');
if ($processPosition === false || $canonicalPosition === false || $processPosition > $canonicalPosition) {
    fwrite(STDERR, "process-env.js must be loaded before canonical-providers.js in admin body mount.
");
    exit(1);
}

if (!str_contains($mountBody, 'w47-browser-process-shim')) {
    fwrite(STDERR, "admin body mount must use the w47 browser process shim cache-buster.
");
    exit(1);
}

$documentBody = file_get_contents($document) ?: '';
if (!str_contains($documentBody, 'w47-browser-process-shim')) {
    fwrite(STDERR, "provider document stylesheet must use the w47 browser process shim cache-buster.
");
    exit(1);
}

echo "Interfacing admin body browser process shim guard passed.
";

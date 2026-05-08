<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

$root = dirname(__DIR__, 2);
$errors = [];

$requiredFiles = [
    'template/interfacing/admin/body/mount.html.twig',
    'template/interfacing/admin/body/schema.html.twig',
    'public/interfacing/admin-body/runtime.js',
    'public/interfacing/admin-body/provider-registry.js',
    'public/interfacing/admin-body/canonical-providers.js',
    'public/interfacing/admin-body/providers/antd-pro.js',
    'public/interfacing/admin-body/providers/primereact.js',
];

foreach ($requiredFiles as $file) {
    if (!is_file($root . '/' . $file)) {
        $errors[] = 'Missing provider browser mount file: ' . $file;
    }
}

$mount = is_file($root . '/template/interfacing/admin/body/mount.html.twig')
    ? file_get_contents($root . '/template/interfacing/admin/body/mount.html.twig')
    : '';
$schema = is_file($root . '/template/interfacing/admin/body/schema.html.twig')
    ? file_get_contents($root . '/template/interfacing/admin/body/schema.html.twig')
    : '';
$runtime = is_file($root . '/public/interfacing/admin-body/runtime.js')
    ? file_get_contents($root . '/public/interfacing/admin-body/runtime.js')
    : '';
$antd = is_file($root . '/public/interfacing/admin-body/providers/antd-pro.js')
    ? file_get_contents($root . '/public/interfacing/admin-body/providers/antd-pro.js')
    : '';

$mustContain = [
    'mount.html.twig' => [
        'data-interfacing-admin-body-provider-boot-marker="true"',
        'w45-provider-browser-mount',
        'canonical-providers.js',
        'runtime.js',
    ],
    'schema.html.twig' => [
        'items: workbench.rows',
        'admin-body-resource-contract',
    ],
    'runtime.js' => [
        'waiting-for-provider',
        'interfacing:admin-body:provider-registered',
        'interfacing:admin-body:canonical-providers-ready',
    ],
    'providers/antd-pro.js' => [
        'attachAntDesignProProvider();',
        'interfacing:admin-body:canonical-providers-ready',
    ],
];

foreach ($mustContain as $file => $needles) {
    $haystack = match ($file) {
        'mount.html.twig' => $mount,
        'schema.html.twig' => $schema,
        'runtime.js' => $runtime,
        'providers/antd-pro.js' => $antd,
        default => '',
    };

    foreach ($needles as $needle) {
        if (!str_contains($haystack, $needle)) {
            $errors[] = sprintf('%s does not contain required provider browser mount marker: %s', $file, $needle);
        }
    }
}

$forbiddenInMount = ['easyadmin', '<table', 'class="table'];
foreach ($forbiddenInMount as $forbidden) {
    if (stripos($mount, $forbidden) !== false) {
        $errors[] = 'mount.html.twig contains forbidden fallback/admin UI marker: ' . $forbidden;
    }
}

if ($errors !== []) {
    fwrite(STDERR, implode(PHP_EOL, $errors) . PHP_EOL);
    exit(1);
}

echo 'Interfacing admin body provider browser mount guard passed.' . PHP_EOL;

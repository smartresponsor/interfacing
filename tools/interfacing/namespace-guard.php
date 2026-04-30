<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * Interfacing namespace guard (RVE-B11)
 * - Enforce Symfony standard namespace prefix: App\Interfacing\
 * - Forbid legacy vendor prefix: SmartResponsor\
 *
 * Usage:
 *   php tools/interfacing/namespace-guard.php
 */
$root = dirname(__DIR__, 2);

$forbidden = [
    'namespace SmartResponsor\\',
    'use SmartResponsor\\',
    'SmartResponsor\\Interfacing\\',
];

$scanDir = [
    $root . '/src',
    $root . '/test',
    $root . '/tests',
    $root . '/config',
    $root . '/composer.json',
];

$hit = [];
foreach ($scanDir as $path) {
    if (is_file($path)) {
        $txt = (string) file_get_contents($path);
        foreach ($forbidden as $needle) {
            if (strpos($txt, $needle) !== false) {
                $hit[] = [$path, $needle];
            }
        }
        continue;
    }
    if (!is_dir($path)) {
        continue;
    }
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    foreach ($it as $f) {
        if (!$f->isFile()) {
            continue;
        }
        $ext = strtolower(pathinfo($f->getFilename(), PATHINFO_EXTENSION));
        if (!in_array($ext, ['php', 'yaml', 'yml', 'json'], true)) {
            continue;
        }
        $txt = (string) file_get_contents($f->getPathname());
        foreach ($forbidden as $needle) {
            if (strpos($txt, $needle) !== false) {
                $hit[] = [$f->getPathname(), $needle];
            }
        }
    }
}

if ($hit !== []) {
    fwrite(STDERR, "Namespace guard: FAIL\n");
    foreach ($hit as [$file, $needle]) {
        fwrite(STDERR, '- ' . $file . ' contains: ' . $needle . "\n");
    }
    exit(2);
}

fwrite(STDOUT, "Namespace guard: ok\n");

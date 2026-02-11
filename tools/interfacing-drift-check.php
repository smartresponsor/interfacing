<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * Interfacing drift check (RVE-A6)
 * - detects forbidden imports and patterns that indicate boundary violations.
 * - keep it fast and dependency-free.
 */

$root = \dirname(__DIR__);
$src = $root.'/src';
$fail = 0;
$routePathSeen = [];
$routePathFile = [];

/** @return string[] */
function phpFiles(string $dir): array {
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    $out = [];
    foreach ($it as $f) {
        if (!$f->isFile()) { continue; }
        if (\substr($f->getFilename(), -4) !== '.php') { continue; }
        $out[] = $f->getPathname();
    }
    return $out;
}

function report(string $file, string $msg): void {
    fwrite(STDERR, $file.": ".$msg.PHP_EOL);
}

$forbiddenNamespace = [
    // Interfacing must not depend on domain logic from other components.
    'SmartResponsor\\Domain\\',
    'SmartResponsor\\Governance\\',
    'SmartResponsor\\Federation\\',
    'SmartResponsor\\Orchestration\\',
    // Generic "policy engine" usage is forbidden inside Interfacing.
    'PolicyEngine',
    'AccessDecisionManager',
];

$forbiddenToken = [
    // Red flags: domain rules in UI adapter.
    'calculateTotal(',
    'applyDiscount(',
    'reprice(',
    'grant(',
    'revoke(',
];

$allowedPrefix = [
    $src.'/Http/Interfacing/',
    $src.'/Service/Interfacing/',
    $src.'/ServiceInterface/Interfacing/',
    $src.'/Domain/Interfacing/',
    $src.'/Infra/Interfacing/',
];

$files = phpFiles($src);
foreach ($files as $file) {
    $ok = false;
    foreach ($allowedPrefix as $p) {
        if (\str_starts_with($file, $p)) { $ok = true; break; }
    }
    if (!$ok) {
        // Not a failure: Interfacing repo may contain other domains; we scan Interfacing-boundary files only.
        continue;
    }

    $txt = (string)\file_get_contents($file);

    // RVE-B6: detect obvious route-path collisions within Interfacing boundary.
    // We only scan attribute-style routes: #[Route(path: '...')] or #[Route('...')].
    if (\strpos($txt, '#[Route') !== false) {
        if (\preg_match_all("/#\\[Route\\((?:[^\\)]*path:\\s*)?'([^']+)'/m", $txt, $m)) {
            foreach ($m[1] as $path) {
                $k = (string)$path;
                if (!\str_starts_with($k, '/interfacing/')) {
                    continue;
                }
                if (isset($routePathSeen[$k]) && ($routePathFile[$k] ?? '') !== $file) {
                    $fail++;
                    report($file, "route path collision: ".$k." already in ".$routePathFile[$k]);
                } else {
                    $routePathSeen[$k] = 1;
                    $routePathFile[$k] = $file;
                }
            }
        }
    }

    foreach ($forbiddenNamespace as $needle) {
        if (\strpos($txt, $needle) !== false) {
            $fail++;
            report($file, "forbidden reference: ".$needle);
        }
    }
    foreach ($forbiddenToken as $needle) {
        if (\strpos($txt, $needle) !== false) {
            $fail++;
            report($file, "suspicious domain token: ".$needle);
        }
    }
}

if ($fail > 0) {
    fwrite(STDERR, "DRIFT_CHECK_FAILED: ".$fail.PHP_EOL);
    exit(2);
}

fwrite(STDOUT, "DRIFT_CHECK_OK".PHP_EOL);
exit(0);

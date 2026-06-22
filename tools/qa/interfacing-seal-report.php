#!/usr/bin/env php
<?php

declare(strict_types=1);

/*
 * Interfacing final seal report.
 *
 * This report is intentionally read-only. It summarizes the active repository
 * shape guarded by tools/qa/interfacing-canon-lint.php without modifying files.
 */

$root = realpath($argv[1] ?? getcwd());
if (false === $root || !is_dir($root)) {
    fwrite(STDERR, "Invalid repository root.\n");
    exit(2);
}

$path = static fn (string $relative): string => $root.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relative);
$relativePath = static function (string $absolute) use ($root): string {
    $absolute = str_replace('\\', '/', $absolute);
    $base = rtrim(str_replace('\\', '/', $root), '/').'/';

    if (str_starts_with($absolute, $base)) {
        return substr($absolute, strlen($base));
    }

    return $absolute;
};

$allFiles = static function (string $relativeDir, ?callable $filter = null) use ($path, $relativePath): array {
    $dir = $path($relativeDir);
    if (!is_dir($dir)) {
        return [];
    }

    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $file) {
        if (!$file instanceof SplFileInfo || !$file->isFile()) {
            continue;
        }

        $relative = $relativePath($file->getPathname());
        if (null !== $filter && !$filter($relative)) {
            continue;
        }

        $files[] = $relative;
    }

    sort($files);

    return $files;
};

$read = static fn (string $relative): string => file_get_contents($path($relative)) ?: '';

$templateRoots = [];
if (is_dir($path('template'))) {
    foreach (glob($path('templates/*'), GLOB_ONLYDIR) ?: [] as $dir) {
        $templateRoots[] = basename($dir);
    }
}
sort($templateRoots);

$twigFiles = $allFiles('template', static fn (string $file): bool => str_ends_with($file, '.twig'));
$viewBases = array_values(array_filter($twigFiles, static fn (string $file): bool => preg_match('#^templates/[^/]+/base\.html\.twig$#', $file) === 1));
$fullDocumentTemplates = [];
foreach ($twigFiles as $file) {
    $source = $read($file);
    if (preg_match('/<!DOCTYPE\s+html|<html\b/i', $source)) {
        $fullDocumentTemplates[] = $file;
    }
}

$literalRefs = 0;
$missingRefs = [];
foreach ($twigFiles as $file) {
    $source = $read($file);
    if (!preg_match_all("/\{%\s*(?:extends|include|embed|import|from)\s+['\"]([^'\"]+)['\"]/", $source, $matches)) {
        continue;
    }

    foreach ($matches[1] as $reference) {
        ++$literalRefs;
        if (str_starts_with($reference, '@!') || str_starts_with($reference, '@EasyAdmin')) {
            continue;
        }

        $candidate = null;
        if (str_starts_with($reference, '@Interfacing/')) {
            $candidate = 'templates/'.substr($reference, strlen('@Interfacing/'));
        } elseif (!str_starts_with($reference, '@') && !str_starts_with($reference, 'templates/')) {
            $candidate = 'templates/'.$reference;
        }

        if (null !== $candidate && !file_exists($path($candidate))) {
            $missingRefs[] = sprintf('%s -> %s', $file, $candidate);
        }
    }
}

$routeFiles = array_merge(
    $allFiles('config', static fn (string $file): bool => str_ends_with($file, '.yaml') || str_ends_with($file, '.yml')),
    $allFiles('src', static fn (string $file): bool => str_ends_with($file, '.php')),
);
$rootCatchAllRoutes = [];
foreach ($routeFiles as $file) {
    $source = $read($file);
    if (preg_match_all('/^\s*path:\s*["\']?\/\{[^\n"\']+/m', $source, $matches)) {
        foreach ($matches[0] as $match) {
            $rootCatchAllRoutes[] = $file.': '.trim($match);
        }
    }
    if (preg_match_all('/#\[Route\(\s*["\']\/\{[^"\']+/m', $source, $matches)) {
        foreach ($matches[0] as $match) {
            $rootCatchAllRoutes[] = $file.': '.trim($match);
        }
    }
}


$runtimeEndpointFiles = array_merge(
    $allFiles('src', static fn (string $file): bool => str_ends_with($file, '.php')),
    $allFiles('config', static fn (string $file): bool => str_ends_with($file, '.yaml') || str_ends_with($file, '.yml')),
);
$viewBaseRenderTargets = [];
foreach ($runtimeEndpointFiles as $file) {
    $source = $read($file);
    if (str_contains($source, "'/base.html.twig'") || str_contains($source, '"/base.html.twig"')) {
        $viewBaseRenderTargets[] = $file.': dynamic /base.html.twig candidate';
    }
    if (preg_match_all('/[\'\"]([a-z0-9][a-z0-9-]*)\/base\.html\.twig[\'\"]/', $source, $matches)) {
        foreach ($matches[1] as $viewName) {
            if ('shell' === $viewName || 'tax' === $viewName || 'accessing' === $viewName) {
                continue;
            }
            $viewBaseRenderTargets[] = $file.': '.$viewName.'/base.html.twig';
        }
    }
}

$activeFiles = [];
foreach (['src', 'config', 'template'] as $dir) {
    $activeFiles = array_merge($activeFiles, $allFiles($dir, static fn (string $file): bool => preg_match('/\.(php|twig|ya?ml)$/', $file) === 1));
}

$retiredNeedles = [
    'shell/base.html.twig',
    'tax/base.html.twig',
    'provider/compatibility_surface.html.twig',
    '/interfacing/bridge',
    '/interfacing/provider/compatibility',
    'runtime_bridges',
    'needs_bridge',
    'interfacing_screen_legacy',
    'interfacing_shell_legacy',
    'legacy_aliases:',
    'legacyAliasMap',
    'shell.left.primary',
    'shell.left.section',
    'footer.primary',
];
$retiredHits = [];
foreach ($activeFiles as $file) {
    $source = $read($file);
    foreach ($retiredNeedles as $needle) {
        if (str_contains($source, $needle)) {
            $retiredHits[] = $file.': '.$needle;
        }
    }
}

$inlineStyleFiles = [];
foreach ($twigFiles as $file) {
    $source = $read($file);
    if ('templates/shell/partial/provider_assets.html.twig' === $file) {
        $source = str_replace('data-interfacing-provider-baseline-inline-style="true"', '', $source);
    }
    if (preg_match('/\sstyle\s*=\s*["\']/', $source)) {
        $inlineStyleFiles[] = $file;
    }
}


$forbiddenSourceStemDirectories = [
    'src/Service/Interfacing',
    'src/ServiceInterface/Interfacing',
    'src/Presentation/Controller/Interfacing',
    'src/Presentation/LiveComponent/Interfacing',
];
$doubleSourceStemDirectories = [];
foreach ($forbiddenSourceStemDirectories as $dir) {
    if (is_dir($path($dir))) {
        $doubleSourceStemDirectories[] = $dir;
    }
}

$forbiddenSourceNamespaceNeedles = [
    'App\\Interfacing\\Service\\Interfacing',
    'App\\Interfacing\\ServiceInterface\\Interfacing',
    'App\\Interfacing\\Presentation\\Controller\\Interfacing',
    'App\\Interfacing\\Presentation\\LiveComponent\\Interfacing',
];
$doubleSourceNamespaceHits = [];
foreach (array_merge($allFiles('src', static fn (string $file): bool => str_ends_with($file, '.php')), $allFiles('config', static fn (string $file): bool => preg_match('/\.ya?ml$/', $file) === 1)) as $file) {
    $source = $read($file);
    foreach ($forbiddenSourceNamespaceNeedles as $needle) {
        if (str_contains($source, $needle)) {
            $doubleSourceNamespaceHits[] = $file.': '.$needle;
        }
    }
}


$forbiddenSourceCatalogFiles = [
    'src/Service/InterfaceActionCatalogService.php',
    'src/Service/InterfaceScreenCatalogService.php',
    'src/Service/Screen',
    'src/ServiceInterface/Screen',
    'src/Service/Registry',
    'src/ServiceInterface/Registry',
    'src/ServiceInterface/InterfaceActionEndpointInterface.php',
    'src/ServiceInterface/InterfaceBaseContextProviderInterface.php',
    'src/ServiceInterface/InterfaceScreenCatalogInterface.php',
    'src/ServiceInterface/InterfaceScreenProviderInterface.php',
    'src/ServiceInterface/Runtime/InterfaceActionRequest.php',
    'src/ServiceInterface/Runtime/InterfaceActionResult.php',
];
$forbiddenSourceCatalogHits = [];
foreach ($forbiddenSourceCatalogFiles as $file) {
    if (file_exists($path($file))) {
        $forbiddenSourceCatalogHits[] = $file;
    }
}

$requiredCanonicalSourceFiles = [
    'src/Catalog/InterfaceActionEndpointCatalog.php',
    'src/Catalog/InterfaceScreenSpecCatalog.php',
    'src/Catalog/AttributeRegistry/InterfaceScreenCatalog.php',
    'src/Catalog/AttributeRegistry/InterfaceActionCatalog.php',
    'src/CatalogInterface/AttributeRegistry/InterfaceScreenCatalogInterface.php',
    'src/CatalogInterface/AttributeRegistry/InterfaceActionCatalogInterface.php',
    'src/Contract/Runtime/InterfaceActionRequest.php',
    'src/Contract/Runtime/InterfaceActionResult.php',
];
$missingCanonicalSourceFiles = [];
foreach ($requiredCanonicalSourceFiles as $file) {
    if (!file_exists($path($file))) {
        $missingCanonicalSourceFiles[] = $file;
    }
}




$obsoleteRegistryNamespaceHits = [];
foreach (array_merge($allFiles('src', static fn (string $file): bool => str_ends_with($file, '.php')), $allFiles('config', static fn (string $file): bool => preg_match('/\.ya?ml$/', $file) === 1)) as $file) {
    $source = $read($file);
    foreach (['App\\Interfacing\\Service\\Registry\\', 'App\\Interfacing\\ServiceInterface\\Registry\\', 'App\\Interfacing\\Service\\Screen\\', 'App\\Interfacing\\ServiceInterface\\Screen\\'] as $needle) {
        if (str_contains($source, $needle)) {
            $obsoleteRegistryNamespaceHits[] = $file.': '.$needle;
        }
    }
}

$businessPublicRoutes = [];
foreach ($allFiles('src/Presentation/Controller', static fn (string $file): bool => str_ends_with($file, '.php')) as $file) {
    $source = $read($file);
    if (preg_match_all('/#\[Route\(\s*["\']\/(?:product|project|category|catalog\/product|catalog\/category|message|access|sign-in|sign-up|sign-out|compliance)(?:[\/\{][^"\']*)?["\']/m', $source, $matches)) {
        foreach ($matches[0] as $match) {
            $businessPublicRoutes[] = $file.': '.trim($match);
        }
    }
}

$implementationInterfaceFiles = [];
foreach (['src/Presentation/LiveComponent', 'src/Integration/Twig', 'src/Support/Doctor'] as $dir) {
    foreach ($allFiles($dir, static fn (string $file): bool => str_ends_with($file, 'Interface.php')) as $file) {
        $implementationInterfaceFiles[] = $file;
    }
}

$voterMisplacement = [];
if (file_exists($path('src/Application/Security/InterfacePermissionVoter.php'))) {
    $voterMisplacement[] = 'src/Application/Security/InterfacePermissionVoter.php';
}
if (!file_exists($path('src/Voter/InterfacePermissionVoter.php'))) {
    $voterMisplacement[] = 'missing src/Voter/InterfacePermissionVoter.php';
}

$report = [];
$report[] = '# Interfacing final seal report';
$report[] = '';
$report[] = 'Generated from the active working tree. This report is read-only and mirrors the executable `composer canon:interfacing` gate.';
$report[] = '';
$report[] = '## Summary';
$report[] = '';
$report[] = sprintf('- Template roots: %d', count($templateRoots));
$report[] = sprintf('- Twig templates: %d', count($twigFiles));
$report[] = sprintf('- View base adapters: %d', count($viewBases));
$report[] = sprintf('- Full document templates: %d', count($fullDocumentTemplates));
$report[] = sprintf('- Literal Twig references scanned: %d', $literalRefs);
$report[] = sprintf('- Missing literal Twig references: %d', count($missingRefs));
$report[] = sprintf('- Root-level catch-all routes: %d', count($rootCatchAllRoutes));
$report[] = sprintf('- Retired active-runtime vocabulary hits: %d', count($retiredHits));
$report[] = sprintf('- Inline `style=` template files: %d', count($inlineStyleFiles));
$report[] = sprintf('- Runtime view-base render targets: %d', count($viewBaseRenderTargets));
$report[] = sprintf('- Double Interfacing source stem directories: %d', count($doubleSourceStemDirectories));
$report[] = sprintf('- Double Interfacing namespace hits: %d', count($doubleSourceNamespaceHits));
$report[] = sprintf('- Forbidden source catalog/runtime alias files: %d', count($forbiddenSourceCatalogHits));
$report[] = sprintf('- Missing canonical source catalog/runtime files: %d', count($missingCanonicalSourceFiles));
$report[] = sprintf('- Obsolete registry/screen namespace hits: %d', count($obsoleteRegistryNamespaceHits));
$report[] = sprintf('- Business-looking public Interfacing routes: %d', count($businessPublicRoutes));
$report[] = sprintf('- Interface files in implementation folders: %d', count($implementationInterfaceFiles));
$report[] = sprintf('- Voter layer placement findings: %d', count($voterMisplacement));
$report[] = '';
$report[] = '## Canonical document base';
$report[] = '';
foreach ($fullDocumentTemplates as $file) {
    $report[] = '- '.$file;
}
$report[] = '';
$report[] = '## Template roots';
$report[] = '';
foreach ($templateRoots as $rootName) {
    $report[] = '- `'.$rootName.'`';
}
$report[] = '';
$report[] = '## Findings';
$report[] = '';
$report[] = count($missingRefs) === 0 ? '- Missing Twig references: none.' : '- Missing Twig references:'."\n  - ".implode("\n  - ", $missingRefs);
$report[] = count($rootCatchAllRoutes) === 0 ? '- Root catch-all routes: none.' : '- Root catch-all routes:'."\n  - ".implode("\n  - ", $rootCatchAllRoutes);
$report[] = count($retiredHits) === 0 ? '- Retired runtime vocabulary: none in active `src`, `config`, or `template` files.' : '- Retired runtime vocabulary:'."\n  - ".implode("\n  - ", $retiredHits);
$report[] = count($inlineStyleFiles) === 0 ? '- Inline `style=` attributes: none outside the provider baseline emitter.' : '- Inline `style=` attributes:'."\n  - ".implode("\n  - ", $inlineStyleFiles);
$report[] = count($viewBaseRenderTargets) === 0 ? '- Runtime view-base render targets: none.' : '- Runtime view-base render targets:' . "\n  - " . implode("\n  - ", $viewBaseRenderTargets);
$report[] = count($doubleSourceStemDirectories) === 0 ? '- Double Interfacing source stem directories: none.' : '- Double Interfacing source stem directories:' . "\n  - " . implode("\n  - ", $doubleSourceStemDirectories);
$report[] = count($doubleSourceNamespaceHits) === 0 ? '- Double Interfacing namespace references: none.' : '- Double Interfacing namespace references:' . "\n  - " . implode("\n  - ", $doubleSourceNamespaceHits);
$report[] = count($forbiddenSourceCatalogHits) === 0 ? '- Forbidden source catalog/runtime alias files: none.' : '- Forbidden source catalog/runtime alias files:' . "\n  - " . implode("\n  - ", $forbiddenSourceCatalogHits);
$report[] = count($missingCanonicalSourceFiles) === 0 ? '- Missing canonical source catalog/runtime files: none.' : '- Missing canonical source catalog/runtime files:' . "\n  - " . implode("\n  - ", $missingCanonicalSourceFiles);
$report[] = count($obsoleteRegistryNamespaceHits) === 0 ? '- Obsolete registry/screen namespace hits: none.' : '- Obsolete registry/screen namespace hits:' . "\n  - " . implode("\n  - ", $obsoleteRegistryNamespaceHits);
$report[] = count($businessPublicRoutes) === 0 ? '- Business-looking public Interfacing routes: none.' : '- Business-looking public Interfacing routes:' . "\n  - " . implode("\n  - ", $businessPublicRoutes);
$report[] = count($implementationInterfaceFiles) === 0 ? '- Interface files in implementation folders: none.' : '- Interface files in implementation folders:' . "\n  - " . implode("\n  - ", $implementationInterfaceFiles);
$report[] = count($voterMisplacement) === 0 ? '- Voter layer placement findings: none.' : '- Voter layer placement findings:' . "\n  - " . implode("\n  - ", $voterMisplacement);
$report[] = '';
$report[] = '## Seal status';
$report[] = '';
$sealed = count($fullDocumentTemplates) === 1
    && $fullDocumentTemplates === ['templates/base.html.twig']
    && count($missingRefs) === 0
    && count($rootCatchAllRoutes) === 0
    && count($retiredHits) === 0
    && count($inlineStyleFiles) === 0
    && count($viewBaseRenderTargets) === 0
    && count($doubleSourceStemDirectories) === 0
    && count($doubleSourceNamespaceHits) === 0
    && count($forbiddenSourceCatalogHits) === 0
    && count($missingCanonicalSourceFiles) === 0
    && count($obsoleteRegistryNamespaceHits) === 0
    && count($businessPublicRoutes) === 0
    && count($implementationInterfaceFiles) === 0
    && count($voterMisplacement) === 0;
$report[] = $sealed ? 'SEALED: active runtime/templates/config drift gates are clean.' : 'NOT SEALED: see findings above.';
$report[] = '';

$output = implode("\n", $report);
if (($argv[2] ?? null) !== null) {
    file_put_contents($path($argv[2]), $output);
} else {
    fwrite(STDOUT, $output);
}

exit($sealed ? 0 : 1);


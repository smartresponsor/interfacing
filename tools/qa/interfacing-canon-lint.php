#!/usr/bin/env php
<?php

declare(strict_types=1);

/*
 * Interfacing canon lint.
 *
 * This repository is intentionally a Symfony-oriented templates/layout package.
 * The checks below guard the invariants that previously drifted: a single
 * document base, noun/surface template roots, provider-native rendering, scoped
 * CRUD handoff routes, and thin surface base adapters.
 */

$root = realpath($argv[1] ?? getcwd());
if (false === $root || !is_dir($root)) {
    fwrite(STDERR, "Invalid repository root.\n");
    exit(2);
}

$errors = [];
$warnings = [];

$path = static fn (string $relative): string => $root.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relative);
$exists = static fn (string $relative): bool => file_exists($path($relative));
$read = static fn (string $relative): string => file_get_contents($path($relative)) ?: '';

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

$fail = static function (string $message) use (&$errors): void {
    $errors[] = $message;
};

$warn = static function (string $message) use (&$warnings): void {
    $warnings[] = $message;
};

// 1. Single document base ownership.
if (!$exists('templates/base.html.twig')) {
    $fail('Missing canonical document base: templates/base.html.twig');
} else {
    $base = $read('templates/base.html.twig');
    if (!preg_match('/<!DOCTYPE\s+html>/i', $base) || !str_contains($base, '<html')) {
        $fail('templates/base.html.twig must remain the only full document shell with <!doctype html> and <html>.');
    }
}

if ($exists('templates/shell/base.html.twig')) {
    $fail('Forbidden parallel document base exists: templates/shell/base.html.twig');
}

if ($exists('src/Presentation/Controller/ShellController.php')) {
    $fail('Retired parallel shell controller exists: src/Presentation/Controller/ShellController.php');
}

if ($exists('templates/navigation/tree.html.twig')) {
    $fail('Retired handwritten navigation tree exists: templates/navigation/tree.html.twig; use provider menu only.');
}

$retiredCompatibilityFiles = [
    'src/ServiceInterface/Access/AccessResolverInterface.php',
    'src/ServiceInterface/AccessResolverInterface.php',
    'src/ServiceInterface/InterfaceActionCatalogInterface.php',
    'src/ServiceInterface/InterfaceActionEndpointInterface.php',
    'src/ServiceInterface/InterfaceBaseContextProviderInterface.php',
    'src/ServiceInterface/InterfaceScreenCatalogInterface.php',
    'src/ServiceInterface/InterfaceScreenProviderInterface.php',
    'src/ServiceInterface/Runtime/InterfaceActionRequest.php',
    'src/ServiceInterface/Runtime/InterfaceActionResult.php',
    'src/ServiceInterface/Security/AccessResolverInterface.php',
    'src/ServiceInterface/Shell/AccessResolverInterface.php',
    'src/Service/Access/SymfonyAccessResolver.php',
    'src/Service/Security/AllowAllAccessResolver.php',
    'src/Service/Security/SymfonyAccessResolver.php',
    'src/Service/Shell/AllowAllAccessResolver.php',
    'src/Service/Shell/SymfonyAccessResolver.php',
];

foreach ($retiredCompatibilityFiles as $file) {
    if ($exists($file)) {
        $fail(sprintf('Retired access/action compatibility wrapper exists: %s', $file));
    }
}

// 2. Forbidden legacy/component template roots.
$forbiddenTemplateRoots = [
    'accessing',
    'accessing-ui',
    'app-host',
    'attaching',
    'bridging',
    'bridge',
    'cataloging',
    'component',
    'interfacing',
    'ordering',
    'paying',
    'shipping',
    'tagging',
    'tax',
    'taxating',
];

foreach ($forbiddenTemplateRoots as $dir) {
    if (is_dir($path('templates/'.$dir))) {
        $fail(sprintf('Forbidden legacy/component template root exists: templates/%s', $dir));
    }
}

// 3. Surface base files must be thin adapters to @Interfacing/base.html.twig.
foreach (glob($path('templates/*/base.html.twig')) ?: [] as $surfaceBasePath) {
    $relative = $relativePath($surfaceBasePath);
    $source = file_get_contents($surfaceBasePath) ?: '';

    if (!preg_match("/\{%\s*extends\s+['\"]@Interfacing\/base\.html\.twig['\"]\s*%\}/", $source)) {
        $fail(sprintf('%s must extend @Interfacing/base.html.twig as a thin surface adapter.', $relative));
    }

    if (preg_match('/<!DOCTYPE\s+html|<html\b/i', $source)) {
        $fail(sprintf('%s must not render a second HTML document shell.', $relative));
    }
}



// 3b. Visible render lookup must not use surface base adapters as endpoints.
// Twig templates may extend a surface base, but PHP/config runtime declarations
// must resolve concrete screens such as <surface>/index.html.twig or data-only handoff.
$runtimeEndpointFiles = array_merge(
    $allFiles('src', static fn (string $file): bool => str_ends_with($file, '.php')),
    $allFiles('config', static fn (string $file): bool => str_ends_with($file, '.yaml') || str_ends_with($file, '.yml')),
);

foreach ($runtimeEndpointFiles as $file) {
    $source = $read($file);

    if (str_contains($source, "'/base.html.twig'") || str_contains($source, '"/base.html.twig"')) {
        $fail(sprintf('Runtime template lookup must not append /base.html.twig as a visible endpoint in %s.', $file));
    }

    if (preg_match_all('/[\'\"]([a-z0-9][a-z0-9-]*)\/base\.html\.twig[\'\"]/', $source, $matches)) {
        foreach ($matches[1] as $surfaceName) {
            if ('shell' === $surfaceName || 'tax' === $surfaceName || 'accessing' === $surfaceName) {
                continue;
            }

            $fail(sprintf('Runtime direct surface-base render target is forbidden in %s: %s/base.html.twig', $file, $surfaceName));
        }
    }
}

// 4. Literal Twig references must resolve inside templates/.
$twigFiles = $allFiles('template', static fn (string $file): bool => str_ends_with($file, '.twig'));
foreach ($twigFiles as $file) {
    $source = $read($file);
    if (!preg_match_all("/\{%\s*(?:extends|include|embed|import|from)\s+['\"]([^'\"]+)['\"]/", $source, $matches)) {
        continue;
    }

    foreach ($matches[1] as $reference) {
        if (str_starts_with($reference, '@!') || str_starts_with($reference, '@EasyAdmin')) {
            continue;
        }

        $candidate = null;
        if (str_starts_with($reference, '@Interfacing/')) {
            $candidate = 'templates/'.substr($reference, strlen('@Interfacing/'));
        } elseif (!str_starts_with($reference, '@') && !str_starts_with($reference, 'templates/')) {
            $candidate = 'templates/'.$reference;
        }

        if (null !== $candidate && !$exists($candidate)) {
            $fail(sprintf('Missing Twig literal reference in %s: %s -> %s', $file, $reference, $candidate));
        }
    }
}

// 5. Root catch-all routes are forbidden for Interfacing cleanup.
$routeFiles = array_merge(
    $allFiles('config', static fn (string $file): bool => str_ends_with($file, '.yaml') || str_ends_with($file, '.yml')),
    $allFiles('src', static fn (string $file): bool => str_ends_with($file, '.php'))
);

foreach ($routeFiles as $file) {
    $source = $read($file);

    if (preg_match_all('/^\s*path:\s*["\']?\/\{[^\n"\']+/m', $source, $matches)) {
        foreach ($matches[0] as $match) {
            $fail(sprintf('Root-level catch-all route is forbidden in %s: %s', $file, trim($match)));
        }
    }

    if (preg_match_all('/#\[Route\(\s*["\']\/\{[^"\']+/m', $source, $matches)) {
        foreach ($matches[0] as $match) {
            $fail(sprintf('Root-level attribute catch-all route is forbidden in %s: %s', $file, trim($match)));
        }
    }
}

// 6. Active runtime/templates/config vocabulary must not reintroduce retired paths.
$retiredRuntimeNeedles = [
    'templates/shell/base.html.twig',
    'shell/base.html.twig',
    'tax/base.html.twig',
    'accessing/base.html.twig',
    'interfacing/home.html.twig',
    'provider/compatibility_surface.html.twig',
    'ProviderCompatibilitySurfaceController',
    '/interfacing/provider/compatibility',
    '/interfacing/bridge',
    'runtime_bridges',
    'needs_bridge',
    'templates/shell.html.twig',
    'shell/index.html.twig',
    '/interfacing/shell-legacy',
    'interfacing_shell_legacy',
    '/interfacing/screen/',
    'interfacing_screen_legacy',
    'interfacing_billing_meter_legacy',
    'interfacing_order_summary_legacy',
    'legacy_aliases:',
    'legacyAliasMap',
    'App\\Interfacing\\ServiceInterface\\Interfacing\\AccessResolverInterface',
    'App\\Interfacing\\ServiceInterface\\Interfacing\\Access\\AccessResolverInterface',
    'App\\Interfacing\\ServiceInterface\\Interfacing\\Security\\AccessResolverInterface',
    'App\\Interfacing\\ServiceInterface\\Interfacing\\Shell\\AccessResolverInterface',
    'App\\Interfacing\\ServiceInterface\\Interfacing\\InterfaceActionCatalogInterface',
    'App\\Interfacing\\Service\\Interfacing\\Access\\SymfonyAccessResolver',
    'App\\Interfacing\\Service\\Interfacing\\Security\\SymfonyAccessResolver',
    'App\\Interfacing\\Service\\Interfacing\\Shell\\SymfonyAccessResolver',
    'shell.left.primary',
    'shell.left.section',
    'left.primary.menu',
    'right.context',
    'footer.primary',
];

$activeFiles = [];
foreach (['src', 'config', 'template'] as $dir) {
    $activeFiles = array_merge($activeFiles, $allFiles($dir, static fn (string $file): bool => preg_match('/\.(php|twig|ya?ml)$/', $file) === 1));
}

foreach ($activeFiles as $file) {
    $source = $read($file);
    foreach ($retiredRuntimeNeedles as $needle) {
        if (str_contains($source, $needle)) {
            $fail(sprintf('Retired runtime/template vocabulary found in %s: %s', $file, $needle));
        }
    }
}

// 7. Inline style attributes are forbidden except the intentional provider baseline emitter.
foreach ($twigFiles as $file) {
    $source = $read($file);
    if ('templates/shell/partial/provider_assets.html.twig' === $file) {
        $source = str_replace('data-interfacing-provider-baseline-inline-style="true"', '', $source);
    }

    if (preg_match('/\sstyle\s*=\s*["\']/', $source)) {
        $fail(sprintf('Inline style attribute found in %s; use provider baseline classes or provider mounts.', $file));
    }
}

// 8. Deprecated compatibility wrappers must not return in active PHP contracts/services.
foreach (['src/ServiceInterface/Interfacing', 'src/Service/Interfacing'] as $dir) {
    foreach ($allFiles($dir, static fn (string $file): bool => str_ends_with($file, '.php')) as $file) {
        $source = $read($file);
        if (str_contains($source, 'Deprecated compatibility')) {
            $fail(sprintf('Deprecated compatibility wrapper retained in active PHP tree: %s', $file));
        }
    }
}


// 9. Source tree must not reintroduce a double Interfacing component stem below already-scoped App\Interfacing.
$forbiddenSourceStemDirectories = [
    'src/Service/Interfacing',
    'src/ServiceInterface/Interfacing',
    'src/Presentation/Controller/Interfacing',
    'src/Presentation/LiveComponent/Interfacing',
];

foreach ($forbiddenSourceStemDirectories as $dir) {
    if (is_dir($path($dir))) {
        $fail(sprintf('Forbidden double component source stem exists: %s', $dir));
    }
}

$forbiddenSourceNamespaceNeedles = [
    'App\\Interfacing\\Service\\Interfacing',
    'App\\Interfacing\\ServiceInterface\\Interfacing',
    'App\\Interfacing\\Presentation\\Controller\\Interfacing',
    'App\\Interfacing\\Presentation\\LiveComponent\\Interfacing',
];

foreach (array_merge($allFiles('src', static fn (string $file): bool => str_ends_with($file, '.php')), $allFiles('config', static fn (string $file): bool => preg_match('/\.ya?ml$/', $file) === 1)) as $file) {
    $source = $read($file);
    foreach ($forbiddenSourceNamespaceNeedles as $needle) {
        if (str_contains($source, $needle)) {
            $fail(sprintf('Forbidden double component namespace reference found in %s: %s', $file, $needle));
        }
    }
}


// 10. Source service catalogs and runtime DTOs must live in typed canonical layers.
$forbiddenSourceCatalogFiles = [
    'src/Service/InterfaceActionCatalogService.php',
    'src/Service/InterfaceScreenCatalogService.php',
    'src/Service/Screen',
    'src/ServiceInterface/Screen',
    'src/Service/Registry',
    'src/ServiceInterface/Registry',
];

foreach ($forbiddenSourceCatalogFiles as $file) {
    if ($exists($file)) {
        $fail(sprintf('Root service catalog file is forbidden; use Service/Catalog typed catalogs: %s', $file));
    }
}

$requiredSourceCatalogFiles = [
    'src/Catalog/InterfaceActionEndpointCatalog.php',
    'src/Catalog/InterfaceScreenSpecCatalog.php',
    'src/Catalog/AttributeRegistry/InterfaceScreenCatalog.php',
    'src/Catalog/AttributeRegistry/InterfaceActionCatalog.php',
    'src/CatalogInterface/AttributeRegistry/InterfaceScreenCatalogInterface.php',
    'src/CatalogInterface/AttributeRegistry/InterfaceActionCatalogInterface.php',
    'src/Contract/Runtime/InterfaceActionRequest.php',
    'src/Contract/Runtime/InterfaceActionResult.php',
];

foreach ($requiredSourceCatalogFiles as $file) {
    if (!$exists($file)) {
        $fail(sprintf('Missing canonical source catalog/runtime contract file: %s', $file));
    }
}

$forbiddenRuntimeContractNeedles = [
    'App\\Interfacing\\ServiceInterface\\Runtime\\InterfaceActionRequest',
    'App\\Interfacing\\ServiceInterface\\Runtime\\InterfaceActionResult',
    'App\\Interfacing\\Service\\InterfaceActionCatalogService',
    'App\\Interfacing\\Service\\InterfaceScreenCatalogService',
    'App\\Interfacing\\Service\\Screen\\',
    'App\\Interfacing\\ServiceInterface\\Screen\\',
    'App\\Interfacing\\Service\\Registry\\',
    'App\\Interfacing\\ServiceInterface\\Registry\\',
];

foreach (array_merge($allFiles('src', static fn (string $file): bool => str_ends_with($file, '.php')), $allFiles('config', static fn (string $file): bool => preg_match('/\.ya?ml$/', $file) === 1)) as $file) {
    $source = $read($file);
    foreach ($forbiddenRuntimeContractNeedles as $needle) {
        if (str_contains($source, $needle)) {
            $fail(sprintf('Forbidden source catalog/runtime alias reference found in %s: %s', $file, $needle));
        }
    }
}



// 11. Interfacing must not own business-looking public routes; keep demos/showcases under /interfacing/*.
$forbiddenPublicRoutePatterns = [
    '/#\[Route\(\s*["\']\/(?:product|project|category|catalog\/product|catalog\/category|message|access|sign-in|sign-up|sign-out|compliance)(?:[\/\{][^"\']*)?["\']/m',
];
foreach ($allFiles('src/Presentation/Controller', static fn (string $file): bool => str_ends_with($file, '.php')) as $file) {
    $source = $read($file);
    foreach ($forbiddenPublicRoutePatterns as $pattern) {
        if (preg_match_all($pattern, $source, $matches)) {
            foreach ($matches[0] as $match) {
                $fail(sprintf('Business-looking public route is forbidden in Interfacing; scope it under /interfacing/* in %s: %s', $file, trim($match)));
            }
        }
    }
}

// 12. Symfony security voters belong in the Voter layer, not Application/Security.
if ($exists('src/Application/Security/InterfacePermissionVoter.php')) {
    $fail('Symfony voter must live in src/Voter/InterfacePermissionVoter.php, not src/Application/Security.');
}
if (!$exists('src/Voter/InterfacePermissionVoter.php')) {
    $fail('Missing canonical Symfony voter: src/Voter/InterfacePermissionVoter.php');
}

// 13. Interface contracts must not live inside implementation/presentation/support folders.
$forbiddenImplementationInterfaceRoots = [
    'src/Presentation/LiveComponent',
    'src/Integration/Twig',
    'src/Support/Doctor',
];
foreach ($forbiddenImplementationInterfaceRoots as $dir) {
    foreach ($allFiles($dir, static fn (string $file): bool => str_ends_with($file, 'Interface.php')) as $file) {
        $fail(sprintf('Interface file lives in implementation folder; move it to ServiceInterface/Contract layer: %s', $file));
    }
}

$requiredMovedInterfaceFiles = [
    'src/ServiceInterface/Integration/Twig/InterfaceClassNameTwigExtensionInterface.php',
    'src/ServiceInterface/Integration/Twig/InterfaceTwigExtensionInterface.php',
    'src/ServiceInterface/Support/Doctor/InterfaceDoctorIssueInterface.php',
    'src/ServiceInterface/Support/Doctor/InterfaceDoctorReportInterface.php',
];
foreach ($requiredMovedInterfaceFiles as $file) {
    if (!$exists($file)) {
        $fail(sprintf('Missing canonical moved interface file: %s', $file));
    }
}

foreach ($warnings as $message) {
    fwrite(STDERR, '[WARN] '.$message.PHP_EOL);
}

if ([] !== $errors) {
    foreach ($errors as $message) {
        fwrite(STDERR, '[FAIL] '.$message.PHP_EOL);
    }

    fwrite(STDERR, sprintf("Interfacing canon lint failed with %d error(s).\n", count($errors)));
    exit(1);
}

fwrite(STDOUT, "Interfacing canon lint passed.\n");
exit(0);


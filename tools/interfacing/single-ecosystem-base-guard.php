<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

/**
 * Static guard for the Interfacing single ecosystem base contract.
 *
 * Usage:
 *   php tools/interfacing/single-ecosystem-base-guard.php
 */
$root = dirname(__DIR__, 2);
$errors = [];

requireContains(readProjectFile($root, 'template/base.html.twig', $errors), "extends 'interfacing/shell/base.html.twig'", 'template/base.html.twig must delegate to the Interfacing shell base.', $errors);
requireContains(readProjectFile($root, 'template/interfacing/base.html.twig', $errors), "extends 'interfacing/shell/base.html.twig'", 'template/interfacing/base.html.twig must delegate to the Interfacing shell base.', $errors);

$shellBase = readProjectFile($root, 'template/interfacing/shell/base.html.twig', $errors);
foreach ([
    'data-sr-shell="host-wide"',
    'data-sr-shell-slot="top"',
    'data-sr-shell-slot="left-primary"',
    'data-sr-shell-slot="left-secondary"',
    'data-sr-shell-slot="body"',
    'data-sr-shell-slot="right-context"',
    'data-sr-shell-slot="quick-menu"',
    'data-sr-shell-slot="footer"',
] as $needle) {
    requireContains($shellBase, $needle, 'Shell base is missing required slot marker: ' . $needle, $errors);
}

$controller = readProjectFile($root, 'src/Presentation/Controller/Interfacing/GenericCrudWorkbenchController.php', $errors);
requireContains($controller, "GENERIC_CRUD_TEMPLATE = 'interfacing/crud/generic.html.twig'", 'Generic CRUD controller must render the ordinary generic CRUD template.', $errors);
forbidContains($controller, 'InterfacingCrudShellTemplateContract', 'Generic CRUD controller must not use the removed Cruding shell template contract.', $errors);
forbidContains($controller, 'cruding_host_adapter', 'Generic CRUD controller must not reference a Cruding-specific adapter.', $errors);
forbidContains($controller, 'interfacing/order/summary.html.twig', 'Generic CRUD controller must not render the order summary template.', $errors);

requireContains(readProjectFile($root, 'template/interfacing/crud/generic.html.twig', $errors), "extends 'interfacing/crud/screen.html.twig'", 'Generic CRUD template must enter the ordinary CRUD screen.', $errors);
requireContains(readProjectFile($root, 'template/interfacing/crud/workbench_base.html.twig', $errors), "extends 'interfacing/base.html.twig'", 'CRUD workbench base must enter the Interfacing base.', $errors);
requireContains(readProjectFile($root, 'template/interfacing/crud/screen.html.twig', $errors), "include 'interfacing/admin/body/mount.html.twig'", 'CRUD screen must enter the admin body mount contract.', $errors);
requireContains(readProjectFile($root, 'template/interfacing/admin/body/mount.html.twig', $errors), 'data-admin-body-contract="ant-design-procomponents"', 'Admin body mount must expose the Ant Design ProComponents body contract marker.', $errors);

foreach ([
    'src/Contract/Crud/InterfacingCrudShellTemplateContract.php',
    'template/interfacing/crud/host_shell_adapter.html.twig',
    'template/interfacing/crud/bridge/cruding_host_adapter.html.twig',
    'pack/templates/bundles/CrudingBundle',
    'tools/interfacing/cruding-host-shell-pack-guard.php',
    'tools/interfacing/cruding-host-shell-pack-guard.ps1',
] as $forbiddenPath) {
    forbidPath($root, $forbiddenPath, $errors);
}

scanTwigForForbiddenAdapters($root . '/template', $errors);
scanTwigForForbiddenAdapters($root . '/pack/templates', $errors);

if ($errors !== []) {
    fwrite(STDERR, "Interfacing single ecosystem base guard: FAILED
");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "
");
    }
    exit(2);
}

fwrite(STDOUT, "Interfacing single ecosystem base guard: OK
");
exit(0);

/** @param list<string> $errors */
function readProjectFile(string $root, string $relativePath, array &$errors): string
{
    $path = $root . '/' . $relativePath;
    if (!is_file($path)) {
        $errors[] = 'Missing required file: ' . $relativePath;
        return '';
    }

    return (string) file_get_contents($path);
}

/** @param list<string> $errors */
function requireContains(string $haystack, string $needle, string $message, array &$errors): void
{
    if (!str_contains($haystack, $needle)) {
        $errors[] = $message;
    }
}

/** @param list<string> $errors */
function forbidContains(string $haystack, string $needle, string $message, array &$errors): void
{
    if (str_contains($haystack, $needle)) {
        $errors[] = $message;
    }
}

/** @param list<string> $errors */
function forbidPath(string $root, string $relativePath, array &$errors): void
{
    if (file_exists($root . '/' . $relativePath)) {
        $errors[] = 'Forbidden Cruding-specific adapter/copy artifact still exists: ' . $relativePath;
    }
}

/** @param list<string> $errors */
function scanTwigForForbiddenAdapters(string $root, array &$errors): void
{
    if (!is_dir($root)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $file) {
        if (!$file instanceof SplFileInfo || !$file->isFile() || !str_ends_with($file->getFilename(), '.twig')) {
            continue;
        }

        $path = $file->getPathname();
        $relative = str_replace('\\', '/', $path);
        $template = (string) file_get_contents($path);
        foreach (['cruding_host_adapter', 'host_shell_adapter.html.twig', 'templates/bundles/CrudingBundle'] as $needle) {
            if (str_contains($template, $needle)) {
                $errors[] = 'Forbidden adapter/copy reference in Twig file: ' . $relative;
            }
        }
    }
}

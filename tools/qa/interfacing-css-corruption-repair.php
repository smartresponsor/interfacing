#!/usr/bin/env php
<?php

declare(strict_types=1);

/*
 * Interfacing CSS corruption repair helper.
 *
 * This tool is intentionally scoped to the generated provider baseline asset.
 * It must not scan or rewrite arbitrary repository files.
 */

$arguments = array_slice($argv, 1);
$write = in_array('--write', $arguments, true);
$rootArgument = null;

foreach ($arguments as $argument) {
    if (!str_starts_with($argument, '--')) {
        $rootArgument = $argument;
        break;
    }
}

$root = realpath($rootArgument ?? getcwd());
if (false === $root || !is_dir($root)) {
    fwrite(STDERR, "Invalid repository root.\n");
    exit(2);
}

$relativeFile = 'public/interfacing/design/provider-baseline.css';
$file = $root.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relativeFile);

if (!is_file($file)) {
    fwrite(STDERR, "Missing provider baseline CSS asset.\n");
    exit(2);
}

$source = file_get_contents($file);
if (!is_string($source)) {
    fwrite(STDERR, "Unable to read provider baseline CSS asset.\n");
    exit(2);
}

$pairs = [
    'Coryright' => 'Copyright',
    'Corr' => 'Corp',
    'rrovider' => 'provider',
    'rrimary' => 'primary',
    'rrimary-hover' => 'primary-hover',
    'radding' => 'padding',
    'rage' => 'page',
    'ranel' => 'panel',
    'gar' => 'gap',
    'rorover' => 'popover',
    'imrortant' => 'important',
    'imrort' => 'import',
    'derend' => 'depend',
    'arrle' => 'apple',
    'sracing' => 'spacing',
    'torbar' => 'topbar',
    'tor-' => 'top-',
    'tor:' => 'top:',
    'tor ' => 'top ',
    'Tor ' => 'Top ',
    'disrlay' => 'display',
    'inrut' => 'input',
    'grour' => 'group',
    'drordown' => 'dropdown',
    'rointer' => 'pointer',
    'rlace-items' => 'place-items',
    'rorover-oren' => 'popover-open',
    'backdror' => 'backdrop',
    'transrarent' => 'transparent',
    'temrlate' => 'template',
    'rereat' => 'repeat',
    'rosition' => 'position',
    'urrercase' => 'uppercase',
    'oracity' => 'opacity',
    'clamr' => 'clamp',
    'wrar' => 'wrap',
    'srace-between' => 'space-between',
    'emrty' => 'empty',
    'rrice' => 'price',
    'descrirtion' => 'description',
    'temrlates' => 'templates',
    'rerair' => 'repair',
    'Keer' => 'Keep',
    'exrlicit' => 'explicit',
    'rrevent' => 'prevent',
    'collarsing' => 'collapsing',
    'rages' => 'pages',
    'comract' => 'compact',
];

$fixed = strtr($source, $pairs);
$fixed = preg_replace('/(?<=\\d)rx\\b/', 'px', $fixed);

if (!is_string($fixed)) {
    fwrite(STDERR, "Unable to apply CSS repair.\n");
    exit(2);
}

if ($write && $fixed !== $source) {
    file_put_contents($file, $fixed);
}

fwrite(STDOUT, sprintf("Mode: %s\n", $write ? 'write' : 'dry-run'));
fwrite(STDOUT, sprintf("Changed: %s\n", $fixed !== $source ? 'yes' : 'no'));

$markers = [
    'rrovider',
    'imrortant',
    'radding',
    'disrlay',
    '1rx',
    'gar-',
    'srace-between',
];

foreach ($markers as $marker) {
    if (str_contains($fixed, $marker)) {
        fwrite(STDERR, "Remaining marker: {$marker}\n");
        exit(1);
    }
}

fwrite(STDOUT, "No configured CSS corruption markers remain.\n");

exit(0);

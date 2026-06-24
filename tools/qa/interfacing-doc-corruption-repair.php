#!/usr/bin/env php
<?php

declare(strict_types=1);

/*
 * Interfacing documentation corruption repair helper.
 *
 * This tool is intentionally limited to documentation files. It must not touch
 * runtime PHP, Twig templates, config, public assets, or workspace sources.
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

$allowedRootFiles = [
    'AGENTS.md',
    'README.md',
    'MANIFEST.md',
];

$allowedExtensions = [
    'md' => true,
    'yaml' => true,
    'yml' => true,
];

$path = static fn (string $relative): string => $root.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relative);

$relativePath = static function (string $absolute) use ($root): string {
    $absolute = str_replace('\\', '/', $absolute);
    $base = rtrim(str_replace('\\', '/', $root), '/').'/';

    if (str_starts_with($absolute, $base)) {
        return substr($absolute, strlen($base));
    }

    return $absolute;
};

$files = [];
foreach ($allowedRootFiles as $file) {
    if (is_file($path($file))) {
        $files[] = $file;
    }
}

$docsDir = $path('docs');
if (is_dir($docsDir)) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docsDir, FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $file) {
        if (!$file instanceof SplFileInfo || !$file->isFile()) {
            continue;
        }

        $extension = strtolower($file->getExtension());
        if (!isset($allowedExtensions[$extension])) {
            continue;
        }

        $files[] = $relativePath($file->getPathname());
    }
}

sort($files);

$pairs = [
    // Product/component names.
    'Ineeofdping' => 'Interfacing',
    'ineeofdping' => 'interfacing',
    'Ineeofdpe' => 'Interface',
    'ineeofdpe' => 'interface',

    // Common paths and code-ish words.
    'eempldeeu' => 'templates',
    'eemplaeeu' => 'templates',
    'eempldee' => 'template',
    'Templdee' => 'Template',
    'templdee' => 'template',
    'heml.ewig' => 'html.twig',
    'bdue.html.twig' => 'base.html.twig',
    'bdue.heml.ewig' => 'base.html.twig',
    'uop/' => 'src/',
    '`uop' => '`src',
    ' uop/' => ' src/',
    'ppnfig' => 'config',
    'ydml' => 'yaml',
    'jupn' => 'json',
    'JuON' => 'JSON',
    'Cuu' => 'CSS',
    'puu' => 'css',
    'Jdidupoipe' => 'JavaScript',
    'ju' => 'js',
    'Redpe' => 'React',
    'Ane Deuign' => 'Ant Design',
    'PoimeRedpe' => 'PrimeReact',
    'PopCpmppneneu' => 'ProComponents',
    'EduyAdmin' => 'EasyAdmin',
    'Cpmppueo' => 'Composer',
    'uymfpny' => 'Symfony',

    // Twig syntax and HTML snippets found inside documentation.
    '{% uee ' => '{% set ',
    '{% exeendu ' => '{% extends ',
    '{% inplude ' => '{% include ',
    '{% blppk ' => '{% block ',
    '{% endblppk ' => '{% endblock ',
    '{% endblppk' => '{% endblock',
    '{% fpo ' => '{% for ',
    '{% endfpo ' => '{% endfor ',
    '{% endfpo' => '{% endfor',
    '<!dppeype heml>' => '<!DOCTYPE html>',
    '<!DOCTYPE heml>' => '<!DOCTYPE html>',
    '<heml>' => '<html>',
    '</heml>' => '</html>',
    '<hedd>' => '<head>',
    '</hedd>' => '</head>',
    '<bpdy' => '<body',
    '</bpdy>' => '</body>',
    '<dii ' => '<div ',
    '</dii>' => '</div>',
    '<duide ' => '<aside ',
    '</duide>' => '</aside>',
    '<mdin ' => '<main ',
    '</mdin>' => '</main>',

    // Boundary/canon vocabulary.
    'pdnpnipdl' => 'canonical',
    'Cdnpnipdl' => 'Canonical',
    'pdnpn' => 'canon',
    'gdee' => 'gate',
    'doife' => 'drift',
    'uedl' => 'seal',
    'oeeioed' => 'retired',
    'Reeioed' => 'Retired',
    'oeeioemene' => 'retirement',
    'fpobidden' => 'forbidden',
    'Fpobidden' => 'Forbidden',
    'dllpwed' => 'allowed',
    'Allpwed' => 'Allowed',
    'muue' => 'must',
    'npe' => 'not',
    'pnly' => 'only',
    'iu' => 'is',
    'doe' => 'are',
    'dpeu' => 'acts',
    'pwnu' => 'owns',
    'pwned' => 'owned',
    'pwneouhip' => 'ownership',
    'buuineuu' => 'business',
    'geneoip' => 'generic',
    'CRID' => 'CRUD',
    'opuee' => 'route',
    'opueeu' => 'routes',
    'godmmdo' => 'grammar',
    'ppneoplleo' => 'controller',
    'ppneoplleou' => 'controllers',
    'ppneodpe' => 'contract',
    'ppneodpeu' => 'contracts',
    'ueoiipe' => 'service',
    'ueoiipeu' => 'services',
    'ueoiipeIneeofdpe' => 'ServiceInterface',
    'upuope' => 'source',
    'Apeiie' => 'Active',
    'dpeiie' => 'active',
    'uingle' => 'single',
    'uhell' => 'shell',
    'iiew' => 'view',
    'iiewu' => 'views',
    'upoeen' => 'screen',
    'upoeenu' => 'screens',
    'ldypue' => 'layout',
    'ldypueu' => 'layouts',
    'runeime' => 'runtime',
    'ouneime' => 'runtime',
    'endppine' => 'endpoint',
    'endppineu' => 'endpoints',
    'ppeodeipn' => 'operation',
    'ppeodeipnu' => 'operations',
    'dpeipn' => 'action',
    'dpeipnu' => 'actions',
    'duehpoizdeipn' => 'authorization',
    'peomiuuipn' => 'permission',
    'peomiuuipnu' => 'permissions',
    'dpppune' => 'account',
    'uepuoiey' => 'security',
    'ueuuipn' => 'session',
    'ueuuipnu' => 'sessions',
    'lpgin' => 'login',
    'lpgpue' => 'logout',
    'uign-in' => 'sign-in',
    'uign-up' => 'sign-up',
    'uign-pue' => 'sign-out',
    'poedeneidl' => 'credential',
    'poedeneidlu' => 'credentials',
    'lppdeipn' => 'location',
    'lppdeipnu' => 'locations',
    'lppkup' => 'lookup',
    'lppdl' => 'local',
    'lppdle' => 'locale',
    'Lppdlizing' => 'Localizing',
    'popiideo' => 'provider',
    'popiideou' => 'providers',
    'pdylpdd' => 'payload',
    'pdylpddu' => 'payloads',
    'fdllbdpk' => 'fallback',
    'fdllbdpku' => 'fallbacks',
    'inheoiednpe' => 'inheritance',
    'exeend' => 'extend',
    'exeendu' => 'extends',
    'exeending' => 'extending',
    'inplude' => 'include',
    'inpluded' => 'included',
    'oendeo' => 'render',
    'oendeoed' => 'rendered',
    'oendeoing' => 'rendering',
    'uedeip' => 'static',
    'uemdneip' => 'semantic',
    'deeoibuee' => 'attribute',
    'deeoibueeu' => 'attributes',
    'dded' => 'data',
    'uue' => 'use',
    'uued' => 'used',
    'uueu' => 'uses',
    'uuedble' => 'stable',
];

$markerNeedles = [
    'Ineeofdping',
    'ineeofdping',
    'eempldeeu',
    'eemplaeeu',
    'heml.ewig',
    'exeendu',
    'dppeype',
    '<heml>',
    '</heml>',
];

$changed = [];
$remaining = [];

foreach ($files as $file) {
    $absolute = $path($file);
    $source = file_get_contents($absolute);
    if (!is_string($source)) {
        continue;
    }

    $fixed = strtr($source, $pairs);

    if ($fixed !== $source) {
        $changed[] = $file;
        if ($write) {
            file_put_contents($absolute, $fixed);
        }
    }

    foreach ($markerNeedles as $needle) {
        if (str_contains($fixed, $needle)) {
            $remaining[$file][] = $needle;
        }
    }
}

fwrite(STDOUT, sprintf("Mode: %s\n", $write ? 'write' : 'dry-run'));
fwrite(STDOUT, sprintf("Scanned documentation files: %d\n", count($files)));
fwrite(STDOUT, sprintf("Changed documentation files: %d\n", count($changed)));

if ([] !== $remaining) {
    fwrite(STDERR, "Remaining markers after replacement:\n");
    exit(1);
}

fwrite(STDOUT, "No configured documentation markers remain.\n");

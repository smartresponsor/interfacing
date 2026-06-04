<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$targets = [
    $root . DIRECTORY_SEPARATOR . 'src',
    $root . DIRECTORY_SEPARATOR . 'config',
    $root . DIRECTORY_SEPARATOR . 'bin',
    $root . DIRECTORY_SEPARATOR . 'public',
    $root . DIRECTORY_SEPARATOR . 'tools',
];

$exitCode = 0;

foreach ($targets as $target) {
    if (!is_dir($target) && !is_file($target)) {
        continue;
    }

    if (is_file($target) && str_ends_with($target, '.php')) {
        $cmd = sprintf('php -l %s 2>&1', escapeshellarg($target));
        exec($cmd, $output, $code);
        echo implode(PHP_EOL, $output) . PHP_EOL;
        $output = [];
        if (0 !== $code) {
            $exitCode = $code;
        }
        continue;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($target, FilesystemIterator::SKIP_DOTS)
    );

    /** @var SplFileInfo $file */
    foreach ($iterator as $file) {
        if ('php' !== strtolower($file->getExtension())) {
            continue;
        }

        $path = $file->getPathname();
        $cmd = sprintf('php -l %s 2>&1', escapeshellarg($path));
        exec($cmd, $output, $code);
        echo implode(PHP_EOL, $output) . PHP_EOL;
        $output = [];

        if (0 !== $code) {
            $exitCode = $code;
        }
    }
}

exit($exitCode);

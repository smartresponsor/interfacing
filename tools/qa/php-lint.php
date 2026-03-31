<?php

declare(strict_types=1);

$paths = array_slice($argv, 1);
if ($paths === []) {
    $paths = ['src', 'tests', 'test', 'tools'];
}

$files = [];
foreach ($paths as $path) {
    if (!file_exists($path)) {
        continue;
    }
    if (is_file($path) && str_ends_with($path, '.php')) {
        $files[] = $path;
        continue;
    }
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }
}

sort($files);
$failed = false;
foreach ($files as $file) {
    $command = escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($file) . ' >/dev/null 2>&1';
    exec($command, $output, $exitCode);
    if ($exitCode !== 0) {
        fwrite(STDERR, "PHP lint failed: {$file}
");
        $failed = true;
    }
}

if ($failed) {
    exit(1);
}

fwrite(STDOUT, sprintf('PHP lint passed for %d files.
', count($files)));

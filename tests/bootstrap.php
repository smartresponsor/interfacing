<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$_SERVER['APP_ENV'] ??= 'test';
$_ENV['APP_ENV'] ??= 'test';
$_SERVER['APP_DEBUG'] ??= '1';
$_ENV['APP_DEBUG'] ??= '1';

if (is_file(dirname(__DIR__).'/.env') && method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

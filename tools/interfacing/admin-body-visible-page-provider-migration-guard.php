#!/usr/bin/env php
<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$errors = [];

$providerPage = $root . '/template/interfacing/admin/body/provider_page.html.twig';
if (!is_file($providerPage)) {
    $errors[] = 'Missing canonical visible provider page template: template/interfacing/admin/body/provider_page.html.twig';
} else {
    $providerPageText = file_get_contents($providerPage) ?: '';
    foreach ([
        'providerInteractive',
        'providerBaseTemplate',
        "interfacing/admin/body/provider_document.html.twig",
        "interfacing/base.html.twig",
        "interfacing/admin/body/mount.html.twig",
        "provider: 'antd-pro'",
        "secondaryProvider: 'primereact'",
    ] as $needle) {
        if (!str_contains($providerPageText, $needle)) {
            $errors[] = 'Provider page template must contain ' . $needle . '.';
        }
    }
}

$visibleGlobs = [
    'template/component/*.twig',
    'template/interfacing/billing/*.twig',
    'template/interfacing/category/*.twig',
    'template/interfacing/doctor*.twig',
    'template/interfacing/doctor/*.twig',
    'template/interfacing/layout/*.twig',
    'template/interfacing/live/screen.html.twig',
    'template/interfacing/order/*.twig',
    'template/interfacing/page/*.twig',
    'template/interfacing/screen/*.twig',
    'template/interfacing/screen/message/*.twig',
    'template/interfacing/widget/data-grid/data-grid.html.twig',
    'template/interfacing/widget/form/form.html.twig',
    'template/interfacing/widget/metric/metric.html.twig',
    'template/interfacing/widget/wizard/wizard.html.twig',
];
$forbidden = ['<style', '<table', '<form', 'btn btn-', 'container-fluid', 'class="row"', "class='row'"];
$visibleFiles = [];
foreach ($visibleGlobs as $glob) {
    foreach (glob($root . '/' . $glob) ?: [] as $file) {
        $visibleFiles[$file] = true;
    }
}
foreach (array_keys($visibleFiles) as $file) {
    $rel = str_replace('\\', '/', substr($file, strlen($root) + 1));
    $text = file_get_contents($file) ?: '';
    if (!str_contains($text, "extends 'interfacing/admin/body/provider_page.html.twig'")) {
        $errors[] = $rel . ' must extend interfacing/admin/body/provider_page.html.twig.';
    }
    foreach ($forbidden as $needle) {
        if (stripos($text, $needle) !== false) {
            $errors[] = $rel . ' must not contain provider-bypassing visible page pattern: ' . $needle;
        }
    }
}

$crudModes = [
    'template/interfacing/crud/mode/collection.html.twig',
    'template/interfacing/crud/mode/detail.html.twig',
    'template/interfacing/crud/mode/destructive.html.twig',
    'template/interfacing/crud/mode/form.html.twig',
];
foreach ($crudModes as $rel) {
    $file = $root . '/' . $rel;
    if (!is_file($file)) {
        $errors[] = 'Missing CRUD mode provider surface: ' . $rel;
        continue;
    }
    $text = file_get_contents($file) ?: '';
    if (!str_contains($text, "interfacing/admin/body/mount.html.twig")) {
        $errors[] = $rel . ' must include interfacing/admin/body/mount.html.twig.';
    }
    foreach ($forbidden as $needle) {
        if (stripos($text, $needle) !== false) {
            $errors[] = $rel . ' must not contain provider-bypassing CRUD mode pattern: ' . $needle;
        }
    }
}

if ($errors !== []) {
    fwrite(STDERR, "Interfacing visible page provider migration guard: FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, '- ' . $error . "\n");
    }
    exit(2);
}

echo "Interfacing visible page provider migration guard: OK\n";

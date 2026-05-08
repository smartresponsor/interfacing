<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Tests\Interfacing\Ui;

use App\Interfacing\Contract\Ui\AdminBodyStrictProviderRenderingContract;
use PHPUnit\Framework\TestCase;

final class AdminBodyStrictProviderRenderingContractTest extends TestCase
{
    public function testStrictProviderContractFilesExist(): void
    {
        self::assertSame('canonical-provider-required', AdminBodyStrictProviderRenderingContract::RENDERING_MODE);
        self::assertSame('antd-pro', AdminBodyStrictProviderRenderingContract::PRIMARY_PROVIDER);
        self::assertSame('primereact', AdminBodyStrictProviderRenderingContract::SECONDARY_PROVIDER);

        foreach (AdminBodyStrictProviderRenderingContract::requiredFiles() as $path) {
            self::assertFileExists(self::projectPath($path));
        }
    }

    public function testTwigAdminBodyDoesNotRenderProviderLessUi(): void
    {
        foreach ([
            'template/interfacing/admin/body/mount.html.twig',
            'template/interfacing/crud/screen.html.twig',
            'template/interfacing/crud/workbench_base.html.twig',
        ] as $path) {
            $contents = self::projectFile($path);
            self::assertStringNotContainsString('<style', $contents);
            self::assertStringNotContainsString('admin_body_table_fallback', $contents);
            self::assertStringNotContainsString('admin_body_cards_fallback', $contents);
            self::assertStringNotContainsString('admin_body_form_fallback', $contents);
            self::assertStringNotContainsString('data-admin-body-fallback', $contents);
        }
    }

    private static function projectFile(string $relativePath): string
    {
        return (string) file_get_contents(self::projectPath($relativePath));
    }

    private static function projectPath(string $relativePath): string
    {
        return dirname(__DIR__, 3).'/'.$relativePath;
    }
}

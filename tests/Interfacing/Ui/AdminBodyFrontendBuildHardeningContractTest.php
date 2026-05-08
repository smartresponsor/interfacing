<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Tests\Interfacing\Ui;

use App\Interfacing\Contract\Ui\AdminBodyFrontendBuildHardeningContract;
use PHPUnit\Framework\TestCase;

/**
 * Guards the frontend build hygiene for provider-rendered admin body UI.
 */
final class AdminBodyFrontendBuildHardeningContractTest extends TestCase
{
    public function testContractPinsReactAndBuildEntrypoints(): void
    {
        self::assertSame('interfacing-admin-body-frontend-build-hardening', AdminBodyFrontendBuildHardeningContract::CONTRACT_NAME);
        self::assertSame('^18.3.1', AdminBodyFrontendBuildHardeningContract::REACT_VERSION);
        self::assertSame('^18.3.1', AdminBodyFrontendBuildHardeningContract::REACT_DOM_VERSION);
        self::assertSame(18, AdminBodyFrontendBuildHardeningContract::REACT_MAJOR);
        self::assertSame('publicDir: false', AdminBodyFrontendBuildHardeningContract::VITE_PUBLIC_DIR_SETTING);
        self::assertSame('emptyOutDir: true', AdminBodyFrontendBuildHardeningContract::VITE_EMPTY_OUT_DIR_SETTING);
    }

    public function testPackageJsonUsesCanonicalProviderBuildLine(): void
    {
        $package = json_decode(self::projectFile('package.json'), true, 512, JSON_THROW_ON_ERROR);
        $dependencies = array_merge($package['dependencies'] ?? [], $package['devDependencies'] ?? []);

        self::assertSame('^18.3.1', $dependencies['react'] ?? null);
        self::assertSame('^18.3.1', $dependencies['react-dom'] ?? null);
        self::assertArrayHasKey('antd', $dependencies);
        self::assertArrayHasKey('@ant-design/pro-components', $dependencies);
        self::assertArrayHasKey('primereact', $dependencies);
        self::assertArrayHasKey('primeicons', $dependencies);
        self::assertArrayHasKey('vite', $dependencies);
        self::assertArrayHasKey('@vitejs/plugin-react', $dependencies);
        self::assertArrayNotHasKey('bootstrap', $dependencies);
    }

    public function testViteConfigAvoidsSymfonyPublicDirOverlapWarning(): void
    {
        $vite = self::projectFile(AdminBodyFrontendBuildHardeningContract::VITE_CONFIG);

        self::assertStringContainsString('publicDir: false', $vite);
        self::assertStringContainsString('emptyOutDir: true', $vite);
        self::assertStringContainsString('../../public/interfacing/admin-body', $vite);
        self::assertStringContainsString('canonical-providers.js', $vite);
        self::assertStringNotContainsString('publicDir: true', $vite);
        self::assertStringNotContainsString('emptyOutDir: false', $vite);
    }

    private static function projectFile(string $relativePath): string
    {
        return (string) file_get_contents(dirname(__DIR__, 3).'/'.$relativePath);
    }
}

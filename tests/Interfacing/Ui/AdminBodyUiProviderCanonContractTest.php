<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Tests\Interfacing\Ui;

use App\Interfacing\Contract\Ui\AdminBodyStrictProviderRenderingContract;
use App\Interfacing\Contract\Ui\AdminBodyUiProviderCanonContract;
use PHPUnit\Framework\TestCase;

/**
 * Guards the UI provider canon so agents do not infer Bootstrap or Twig CSS as
 * the admin body design system.
 */
final class AdminBodyUiProviderCanonContractTest extends TestCase
{
    public function testProviderCanonExposesCanonicalProviders(): void
    {
        self::assertSame('antd-pro', AdminBodyUiProviderCanonContract::PRIMARY_PROVIDER);
        self::assertSame('@ant-design/pro-components', AdminBodyUiProviderCanonContract::PRIMARY_PACKAGE);
        self::assertSame('admin-workbench', AdminBodyUiProviderCanonContract::PRIMARY_ROLE);
        self::assertSame('primereact', AdminBodyUiProviderCanonContract::SECONDARY_PROVIDER);
        self::assertSame('rich-facade', AdminBodyUiProviderCanonContract::SECONDARY_ROLE);

        self::assertSame('canonical-provider-required', AdminBodyStrictProviderRenderingContract::RENDERING_MODE);
    }

    public function testPackageJsonContainsCanonicalFrontendProviderPackages(): void
    {
        $package = json_decode(self::projectFile('package.json'), true, 512, JSON_THROW_ON_ERROR);
        $dependencies = array_merge($package['dependencies'] ?? [], $package['devDependencies'] ?? []);

        foreach (['antd', '@ant-design/pro-components', 'primereact', 'primeicons', 'react', 'react-dom', 'vite', 'typescript', '@vitejs/plugin-react'] as $packageName) {
            self::assertArrayHasKey($packageName, $dependencies);
        }

        self::assertSame('^18.3.1', $dependencies['react'] ?? null);
        self::assertSame('^18.3.1', $dependencies['react-dom'] ?? null);

        self::assertArrayNotHasKey('bootstrap', $dependencies);
        self::assertArrayNotHasKey('react-bootstrap', $dependencies);
    }

    public function testDocsMountAndWorkspaceExposeStrictProviderCanon(): void
    {
        $docs = self::projectFile(AdminBodyUiProviderCanonContract::CONTRACT_DOC);
        $mount = self::projectFile('template/interfacing/admin/body/mount.html.twig');
        $provider = self::projectFile('.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx');

        self::assertStringContainsString('Ant Design + ProComponents', $docs);
        self::assertStringContainsString('PrimeReact', $docs);
        self::assertStringContainsString('canonical-provider-required', $docs);
        self::assertStringContainsString('npm run ui:build', $docs);

        self::assertStringContainsString('data-admin-body-rendering-mode="canonical-provider-required"', $mount);
        self::assertStringContainsString('data-admin-body-canonical-provider-bundle="interfacing/admin-body/canonical-providers.js"', $mount);
        self::assertStringNotContainsString('<style', $mount);
        self::assertStringNotContainsString('fallback', $mount);
        self::assertStringNotContainsString('btn btn-', $mount);

        self::assertStringContainsString('@ant-design/pro-components', $provider);
        self::assertStringContainsString('ProTable', $provider);
        self::assertStringContainsString('ProForm', $provider);
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

<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Tests\Interfacing\Ui;

use App\Interfacing\Contract\Ui\AdminBodyRcReadinessContract;
use PHPUnit\Framework\TestCase;

/**
 * Guards the final RC readiness entrypoint for the admin body contract.
 */
final class AdminBodyRcReadinessContractTest extends TestCase
{
    public function testRcReadinessContractExposesCanonicalEntrypoints(): void
    {
        self::assertSame('tools/interfacing/admin-body-rc-readiness.php', AdminBodyRcReadinessContract::GATE_ENTRYPOINT);
        self::assertSame('tools/interfacing/admin-body-rc-readiness.ps1', AdminBodyRcReadinessContract::GATE_WRAPPER);
        self::assertSame('docs/interfacing/interfacing-admin-body-rc-readiness-gate.md', AdminBodyRcReadinessContract::CONTRACT_DOC);
        self::assertSame('admin-body-rc1', AdminBodyRcReadinessContract::RC_MILESTONE);

        foreach (AdminBodyRcReadinessContract::requiredFiles() as $path) {
            self::assertFileExists(self::projectPath($path));
        }
    }

    public function testRcReadinessCriteriaDescribeTheExpectedRcSurface(): void
    {
        self::assertSame([
            'single-ecosystem-shell',
            'central-admin-body-mount',
            'antd-pro-primary-primereact-secondary',
            'versioned-schema-manifest',
            'runtime-smoke-passing',
            'no-cruding-adapter-no-host-copy-drift',
            'consumer-guide-and-contract-index-present',
            'ui-provider-canon-present-and-guarded',
            'frontend-build-hardened-react18-vite-publicdir-disabled',
        ], AdminBodyRcReadinessContract::readinessCriteria());
    }

    public function testRcReadinessWrapperAvoidsCompatibilitySensitiveHelpers(): void
    {
        $wrapper = self::projectFile(AdminBodyRcReadinessContract::GATE_WRAPPER);

        self::assertStringContainsString('admin-body-rc-readiness.php', $wrapper);
        self::assertStringNotContainsString('GetRelativePath', $wrapper);
        self::assertStringNotContainsString('Resolve-RelativePathCompat', $wrapper);
    }

    public function testRcReadinessDocsAndIndexExposeTheMilestone(): void
    {
        $docs = self::projectFile(AdminBodyRcReadinessContract::CONTRACT_DOC);
        $index = self::projectFile('docs/interfacing/interfacing-admin-body-contract-index.md');
        $manifest = self::projectFile('docs/MANIFEST.md');

        self::assertStringContainsString('RC readiness gate', $docs);
        self::assertStringContainsString('admin-body-rc-readiness.php', $docs);
        self::assertStringContainsString('admin-body-rc1', $docs);
        self::assertStringContainsString('Ant Design ProComponents primary', $docs);
        self::assertStringContainsString('PrimeReact secondary', $docs);
        self::assertStringContainsString('No HostApp copy surface', $docs);
        self::assertStringContainsString('No Cruding-specific adapter', $docs);

        self::assertStringContainsString('admin-body-rc-readiness.php', $index);
        self::assertStringContainsString('admin-body-rc1', $index);
        self::assertStringContainsString(AdminBodyRcReadinessContract::CONTRACT_DOC, $manifest);
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

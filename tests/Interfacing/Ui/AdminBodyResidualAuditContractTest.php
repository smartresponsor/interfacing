<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Tests\Interfacing\Ui;

use App\Interfacing\Contract\Ui\AdminBodyResidualAuditContract;
use PHPUnit\Framework\TestCase;

/**
 * Guards the residual cleanup audit before admin body RC promotion.
 */
final class AdminBodyResidualAuditContractTest extends TestCase
{
    public function testResidualAuditContractExposesCanonicalEntrypoints(): void
    {
        self::assertSame('tools/interfacing/admin-body-residual-audit.php', AdminBodyResidualAuditContract::GUARD_ENTRYPOINT);
        self::assertSame('tools/interfacing/admin-body-residual-audit.ps1', AdminBodyResidualAuditContract::GUARD_WRAPPER);
        self::assertSame('docs/interfacing/interfacing-admin-body-residual-audit-cleanup.md', AdminBodyResidualAuditContract::CONTRACT_DOC);

        foreach (AdminBodyResidualAuditContract::requiredFiles() as $path) {
            self::assertFileExists(self::projectPath($path));
        }
    }

    public function testForbiddenResidualArtifactsAreAbsent(): void
    {
        foreach (AdminBodyResidualAuditContract::forbiddenPaths() as $path) {
            self::assertFileDoesNotExist(self::projectPath($path), 'Forbidden residual artifact still exists: '.$path);
        }
    }

    public function testResidualAuditIsIncludedInRcGuard(): void
    {
        $rcGuard = self::projectFile('tools/interfacing/admin-body-rc-guard.php');

        self::assertStringContainsString('admin-body-residual-audit.php', $rcGuard);
        self::assertStringContainsString('Interfacing admin body residual audit', $rcGuard);
    }

    public function testResidualAuditWrappersAvoidCompatibilitySensitiveHelpers(): void
    {
        foreach ([
            'tools/interfacing/admin-body-rc-guard.ps1',
            AdminBodyResidualAuditContract::GUARD_WRAPPER,
        ] as $wrapperPath) {
            $wrapper = self::projectFile($wrapperPath);

            self::assertStringNotContainsString('GetRelativePath', $wrapper);
            self::assertStringNotContainsString('Resolve-RelativePathCompat', $wrapper);
        }
    }

    public function testResidualAuditDocsDescribeCleanupScope(): void
    {
        $docs = self::projectFile(AdminBodyResidualAuditContract::CONTRACT_DOC);

        self::assertStringContainsString('Residual audit', $docs);
        self::assertStringContainsString('admin-body-residual-audit.php', $docs);
        self::assertStringContainsString('admin-body-rc-guard.php', $docs);
        self::assertStringContainsString('no Cruding-specific adapter', $docs);
        self::assertStringContainsString('no HostApp copy surface', $docs);
        self::assertStringContainsString('no `GetRelativePath` dependency', $docs);
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

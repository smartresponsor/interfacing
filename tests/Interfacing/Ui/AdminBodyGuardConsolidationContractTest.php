<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Tests\Interfacing\Ui;

use App\Interfacing\Contract\Ui\AdminBodyGuardConsolidationContract;
use PHPUnit\Framework\TestCase;

/**
 * Guards the consolidated RC-facing admin body guard entrypoint.
 */
final class AdminBodyGuardConsolidationContractTest extends TestCase
{
    public function testConsolidatedGuardContractExposesCanonicalEntrypoints(): void
    {
        self::assertSame('tools/interfacing/admin-body-rc-guard.php', AdminBodyGuardConsolidationContract::CONSOLIDATED_GUARD_ENTRYPOINT);
        self::assertSame('tools/interfacing/admin-body-rc-guard.ps1', AdminBodyGuardConsolidationContract::CONSOLIDATED_GUARD_WRAPPER);
        self::assertSame('docs/interfacing/interfacing-admin-body-guard-consolidation.md', AdminBodyGuardConsolidationContract::CONTRACT_DOC);
        self::assertSame('tools/interfacing/admin-body-mount-contract-guard.php', AdminBodyGuardConsolidationContract::ADMIN_BODY_STATIC_GUARD);
        self::assertSame('tools/interfacing/single-ecosystem-base-guard.php', AdminBodyGuardConsolidationContract::SINGLE_ECOSYSTEM_BASE_GUARD);
        self::assertSame('tools/interfacing/admin-body-runtime-smoke.mjs', AdminBodyGuardConsolidationContract::RUNTIME_SMOKE_HARNESS);
        self::assertSame('tools/interfacing/admin-body-residual-audit.php', AdminBodyGuardConsolidationContract::RESIDUAL_AUDIT_GUARD);

        foreach (AdminBodyGuardConsolidationContract::requiredGuardFiles() as $path) {
            self::assertFileExists(self::projectPath($path));
        }
    }

    public function testConsolidatedGuardWrapperAvoidsGetRelativePath(): void
    {
        $wrapper = self::projectFile(AdminBodyGuardConsolidationContract::CONSOLIDATED_GUARD_WRAPPER);

        self::assertStringContainsString('admin-body-rc-guard.php', $wrapper);
        self::assertStringNotContainsString('GetRelativePath', $wrapper);
    }

    public function testConsolidationDocsDescribeRcGuardPlan(): void
    {
        $docs = self::projectFile(AdminBodyGuardConsolidationContract::CONTRACT_DOC);

        self::assertStringContainsString('admin-body-rc-guard.php', $docs);
        self::assertStringContainsString('admin-body-mount-contract-guard.php', $docs);
        self::assertStringContainsString('single-ecosystem-base-guard.php', $docs);
        self::assertStringContainsString('admin-body-runtime-smoke.mjs', $docs);
        self::assertStringContainsString('admin-body-residual-audit.php', $docs);
        self::assertStringContainsString('No HostApp copy surface', $docs);
        self::assertStringContainsString('No Cruding-specific adapter', $docs);
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

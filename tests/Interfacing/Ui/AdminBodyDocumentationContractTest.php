<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Tests\Interfacing\Ui;

use App\Interfacing\Contract\Ui\AdminBodyDocumentationContract;
use PHPUnit\Framework\TestCase;

/**
 * Guards the human-readable admin body consumer documentation surface.
 */
final class AdminBodyDocumentationContractTest extends TestCase
{
    public function testDocumentationContractExposesCanonicalEntrypoints(): void
    {
        self::assertSame('docs/interfacing/interfacing-admin-body-contract-index.md', AdminBodyDocumentationContract::CONTRACT_INDEX);
        self::assertSame('docs/interfacing/interfacing-admin-body-consumer-guide.md', AdminBodyDocumentationContract::CONSUMER_GUIDE);
        self::assertSame('single-ecosystem-shell-central-admin-body-slot', AdminBodyDocumentationContract::CANONICAL_BASE_MODEL);
        self::assertSame('antd-pro', AdminBodyDocumentationContract::PRIMARY_PROVIDER);
        self::assertSame('primereact', AdminBodyDocumentationContract::SECONDARY_PROVIDER);

        foreach (AdminBodyDocumentationContract::requiredDocs() as $docPath) {
            self::assertFileExists(self::projectPath($docPath));
        }
    }

    public function testContractIndexDocumentsTheProviderAndPolicyMap(): void
    {
        $index = self::projectFile(AdminBodyDocumentationContract::CONTRACT_INDEX);

        self::assertStringContainsString('single ecosystem shell', $index);
        self::assertStringContainsString('central admin body mount', $index);
        self::assertStringContainsString('antd-pro', $index);
        self::assertStringContainsString('primereact', $index);
        self::assertStringContainsString('Policy map', $index);
        self::assertStringContainsString('resourceContract', $index);
        self::assertStringContainsString('toolbarPolicy', $index);
        self::assertStringContainsString('authorizationPolicy', $index);
        self::assertStringContainsString('responsiveLayoutPolicy', $index);
        self::assertStringNotContainsString('cruding_host_adapter', $index);
        self::assertStringNotContainsString('templates/bundles/CrudingBundle', $index);
    }

    public function testConsumerGuideForbidsHostCopyAndSpecialCrudShells(): void
    {
        $guide = self::projectFile(AdminBodyDocumentationContract::CONSUMER_GUIDE);

        self::assertStringContainsString('shared ecosystem shell', $guide);
        self::assertStringContainsString('central body slot', $guide);
        self::assertStringContainsString('Do not create a component-specific shell for CRUD pages.', $guide);
        self::assertStringContainsString('Do not copy generated override files into HostApp as the primary model.', $guide);
        self::assertStringContainsString('Cruding should not be special-cased.', $guide);
        self::assertStringContainsString('Ant Design ProComponents owns the canonical admin workbench rendering', $guide);
        self::assertStringContainsString('PrimeReact may be used for rich facade', $guide);
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

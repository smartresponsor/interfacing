<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Tests\Interfacing\Crud;

use PHPUnit\Framework\TestCase;

/**
 * Guards the single ecosystem shell and strict canonical-provider admin body.
 */
final class CrudShellInheritanceContractTest extends TestCase
{
    public function testHostFacingBaseDelegatesToInterfacingShellBase(): void
    {
        $template = self::projectFile('template/base.html.twig');

        self::assertStringContainsString("extends 'interfacing/shell/base.html.twig'", $template);
        self::assertStringNotContainsString('data-sr-shell="host-wide"', $template, 'The host base must not duplicate shell markup.');
    }

    public function testCrudTemplatesEnterSingleEcosystemBaseAndStrictProviderMount(): void
    {
        $generic = self::projectFile('template/interfacing/crud/generic.html.twig');
        $workbench = self::projectFile('template/interfacing/crud/workbench_base.html.twig');
        $base = self::projectFile('template/interfacing/base.html.twig');
        $screen = self::projectFile('template/interfacing/crud/screen.html.twig');
        $mount = self::projectFile('template/interfacing/admin/body/mount.html.twig');

        self::assertStringContainsString("extends 'interfacing/crud/screen.html.twig'", $generic);
        self::assertStringContainsString("extends 'interfacing/base.html.twig'", $workbench);
        self::assertStringContainsString("extends 'interfacing/shell/base.html.twig'", $base);
        self::assertStringContainsString("include 'interfacing/admin/body/mount.html.twig'", $screen);
        self::assertStringContainsString("provider: 'antd-pro'", $screen);
        self::assertStringContainsString("secondaryProvider: 'primereact'", $screen);
        self::assertStringContainsString('data-admin-body-rendering-mode="canonical-provider-required"', $mount);
        self::assertStringContainsString('data-admin-body-canonical-provider-bundle="interfacing/admin-body/canonical-providers.js"', $mount);
    }

    public function testCrudBodyDoesNotRenderNativeFallbackUiOrInlineCss(): void
    {
        $workbench = self::projectFile('template/interfacing/crud/workbench_base.html.twig');
        $screen = self::projectFile('template/interfacing/crud/screen.html.twig');
        $mount = self::projectFile('template/interfacing/admin/body/mount.html.twig');

        foreach ([$workbench, $screen, $mount] as $template) {
            self::assertStringNotContainsString('<style', $template);
            self::assertStringNotContainsString('admin_body_table_fallback', $template);
            self::assertStringNotContainsString('admin_body_cards_fallback', $template);
            self::assertStringNotContainsString('admin_body_form_fallback', $template);
            self::assertStringNotContainsString('data-admin-body-fallback', $template);
            self::assertStringNotContainsString('btn btn-', $template);
            self::assertStringNotContainsString('container-fluid', $template);
        }
    }

    public function testRuntimeUsesProviderRequiredErrorInsteadOfProviderLessUi(): void
    {
        $runtime = self::projectFile('assets/interfacing/admin-body/runtime.js');
        $schema = self::projectFile('template/interfacing/admin/body/schema.html.twig');

        self::assertStringContainsString("PROVIDER_REQUIRED_ERROR_EVENT = 'interfacing:admin-body:provider-required-error'", $runtime);
        self::assertStringContainsString("mount.dataset[HYDRATION_ATTR] = providerName ? 'provider-required-error' : 'provider-policy-error'", $runtime);
        self::assertStringContainsString('requireCanonicalProviders: true', $schema);
        self::assertStringContainsString("providerPolicy: 'canonical-provider-required'", $schema);
        self::assertStringNotContainsString('primary-provider-missing', $runtime);
        self::assertStringNotContainsString('primary-provider-missing', $schema);
        self::assertStringNotContainsString("'fallback'", $schema);
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

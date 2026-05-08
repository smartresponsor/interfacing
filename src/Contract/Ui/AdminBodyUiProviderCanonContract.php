<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Canonical UI provider contract for Interfacing and consumer repositories.
 *
 * This contract exists so local agents and Codex runs do not infer Bootstrap,
 * handmade Twig CSS, or composer-backed design providers from a Symfony slice.
 * Composer packages provide PHP/Symfony infrastructure. The admin/workbench
 * body design providers live in the frontend/NPM surface and are exposed to
 * Symfony through the Interfacing admin body mount/schema/runtime contract.
 */
final readonly class AdminBodyUiProviderCanonContract
{
    public const CANON_NAME = 'interfacing-admin-body-ui-provider-canon';
    public const CANON_VERSION = '1.0';

    public const CONTRACT_DOC = 'docs/interfacing/interfacing-admin-body-ui-provider-canon.md';
    public const GUARD_ENTRYPOINT = 'tools/interfacing/admin-body-ui-provider-canon-guard.php';
    public const GUARD_WRAPPER = 'tools/interfacing/admin-body-ui-provider-canon-guard.ps1';

    public const PRIMARY_PROVIDER = 'antd-pro';
    public const PRIMARY_PACKAGE = '@ant-design/pro-components';
    public const PRIMARY_LIBRARY = 'antd';
    public const PRIMARY_ROLE = 'admin-workbench';

    public const SECONDARY_PROVIDER = 'primereact';
    public const SECONDARY_PACKAGE = 'primereact';
    public const SECONDARY_ICON_PACKAGE = 'primeicons';
    public const SECONDARY_ROLE = 'rich-facade';

    public const RUNTIME_ENTRYPOINT = AdminBodyRuntimeContract::ENTRYPOINT;
    public const PROVIDER_REGISTRY_ENTRYPOINT = AdminBodyProviderRegistryContract::ENTRYPOINT;
    public const ANTD_PRO_PROVIDER_ATTACHMENT = AdminBodyAntDesignProProviderContract::ENTRYPOINT;
    public const PRIMEREACT_PROVIDER_ATTACHMENT = AdminBodyPrimeReactProviderContract::ENTRYPOINT;

    public const FORBIDDEN_PROVIDER_ASSUMPTION_BOOTSTRAP = 'bootstrap';
    public const FORBIDDEN_ADMIN_TWIG_DESIGN_SYSTEM = 'handmade-twig-css-admin-body';
    public const FORBIDDEN_COMPOSER_UI_PROVIDER_INFERENCE = 'composer-design-provider-inference';
    public const FRONTEND_BUILD_HARDENING = AdminBodyFrontendBuildHardeningContract::CONTRACT_NAME;

    /** @return array<string, string> */
    public static function providerRoles(): array
    {
        return [
            self::PRIMARY_PROVIDER => self::PRIMARY_ROLE,
            self::SECONDARY_PROVIDER => self::SECONDARY_ROLE,
        ];
    }

    /** @return list<string> */
    public static function requiredNpmPackages(): array
    {
        return [
            self::PRIMARY_LIBRARY,
            self::PRIMARY_PACKAGE,
            self::SECONDARY_PACKAGE,
            self::SECONDARY_ICON_PACKAGE,
            'react',
            'react-dom',
        ];
    }

    /** @return list<string> */
    public static function requiredFiles(): array
    {
        return [
            self::CONTRACT_DOC,
            self::GUARD_ENTRYPOINT,
            self::GUARD_WRAPPER,
            self::RUNTIME_ENTRYPOINT,
            self::PROVIDER_REGISTRY_ENTRYPOINT,
            self::ANTD_PRO_PROVIDER_ATTACHMENT,
            self::PRIMEREACT_PROVIDER_ATTACHMENT,
            'package.json',
            AdminBodyFrontendBuildHardeningContract::CONTRACT_DOC,
            AdminBodyFrontendBuildHardeningContract::GUARD_ENTRYPOINT,
            'docs/interfacing/interfacing-admin-body-contract-index.md',
            'docs/interfacing/interfacing-admin-body-consumer-guide.md',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Frontend build hardening contract for canonical provider-rendered admin body UI.
 *
 * This contract exists to keep the browser provider build stable after the
 * Interfacing admin body moved from Twig/CSS rendering to strict Ant Design
 * ProComponents and PrimeReact provider rendering.
 */
final readonly class AdminBodyFrontendBuildHardeningContract
{
    public const CONTRACT_NAME = 'interfacing-admin-body-frontend-build-hardening';
    public const CONTRACT_VERSION = '1.0';

    public const CONTRACT_DOC = 'docs/interfacing/interfacing-admin-body-frontend-build-hardening.md';
    public const GUARD_ENTRYPOINT = 'tools/interfacing/admin-body-frontend-build-guard.php';
    public const GUARD_WRAPPER = 'tools/interfacing/admin-body-frontend-build-guard.ps1';

    public const PACKAGE_JSON = 'package.json';
    public const VITE_CONFIG = '.interfacing/workspace/vite.config.ts';
    public const UI_BUILD_COMMAND = 'npm run ui:build';
    public const UI_CHECK_COMMAND = 'npm run ui:check';
    public const UI_AUDIT_COMMAND = 'npm audit';

    public const REACT_VERSION = '^18.3.1';
    public const REACT_DOM_VERSION = '^18.3.1';
    public const REACT_MAJOR = 18;

    public const VITE_PUBLIC_DIR_SETTING = 'publicDir: false';
    public const VITE_EMPTY_OUT_DIR_SETTING = 'emptyOutDir: true';
    public const VITE_OUTPUT_FILE = 'public/interfacing/admin-body/canonical-providers.js';

    /** @return array<string, string> */
    public static function requiredDependencyVersions(): array
    {
        return [
            'react' => self::REACT_VERSION,
            'react-dom' => self::REACT_DOM_VERSION,
            'antd' => '^5.26.7',
            '@ant-design/pro-components' => '^2.8.10',
            'primereact' => '^10.9.7',
            'primeicons' => '^7.0.0',
        ];
    }

    /** @return list<string> */
    public static function requiredFiles(): array
    {
        return [
            self::PACKAGE_JSON,
            self::VITE_CONFIG,
            self::CONTRACT_DOC,
            self::GUARD_ENTRYPOINT,
            self::GUARD_WRAPPER,
            '.interfacing/workspace/src/admin-body/main.tsx',
            '.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx',
            '.interfacing/workspace/src/admin-body/PrimeReactAdminBodyProvider.tsx',
        ];
    }
}

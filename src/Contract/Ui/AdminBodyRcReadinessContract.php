<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * RC readiness gate for the Interfacing admin body contract.
 *
 * This contract does not add a new rendering layer. It marks the admin body
 * contract line as RC-ready once shell inheritance, provider policy, schema
 * manifest, runtime smoke, residual cleanup, and consolidated guards are all
 * available and executable.
 */
final readonly class AdminBodyRcReadinessContract
{
    public const GATE_ENTRYPOINT = 'tools/interfacing/admin-body-rc-readiness.php';
    public const GATE_WRAPPER = 'tools/interfacing/admin-body-rc-readiness.ps1';
    public const CONTRACT_DOC = 'docs/interfacing/interfacing-admin-body-rc-readiness-gate.md';

    public const GATE_NAME = 'interfacing-admin-body-rc-readiness';
    public const GATE_VERSION = '1.0';
    public const RC_MILESTONE = 'admin-body-rc1';

    public const CONSOLIDATED_GUARD = AdminBodyGuardConsolidationContract::CONSOLIDATED_GUARD_ENTRYPOINT;
    public const RESIDUAL_AUDIT_GUARD = AdminBodyResidualAuditContract::GUARD_ENTRYPOINT;
    public const RUNTIME_SMOKE_HARNESS = AdminBodyRuntimeSmokeContract::HARNESS_ENTRYPOINT;
    public const SCHEMA_MANIFEST_CONTRACT = AdminBodySchemaManifestContract::class;
    public const DOCUMENTATION_INDEX = AdminBodyDocumentationContract::CONTRACT_INDEX_DOC;
    public const UI_PROVIDER_CANON_GUARD = AdminBodyUiProviderCanonContract::GUARD_ENTRYPOINT;
    public const FRONTEND_BUILD_GUARD = AdminBodyFrontendBuildHardeningContract::GUARD_ENTRYPOINT;

    public const SHELL_CRITERION = 'single-ecosystem-shell';
    public const BODY_CRITERION = 'central-admin-body-mount';
    public const PROVIDER_CRITERION = 'antd-pro-primary-primereact-secondary';
    public const SCHEMA_CRITERION = 'versioned-schema-manifest';
    public const RUNTIME_CRITERION = 'runtime-smoke-passing';
    public const RESIDUAL_CRITERION = 'no-cruding-adapter-no-host-copy-drift';
    public const DOCS_CRITERION = 'consumer-guide-and-contract-index-present';
    public const UI_PROVIDER_CANON_CRITERION = 'ui-provider-canon-present-and-guarded';
    public const FRONTEND_BUILD_CRITERION = 'frontend-build-hardened-react18-vite-publicdir-disabled';

    /** @return list<string> */
    public static function requiredFiles(): array
    {
        return [
            self::GATE_ENTRYPOINT,
            self::GATE_WRAPPER,
            self::CONTRACT_DOC,
            self::CONSOLIDATED_GUARD,
            self::RESIDUAL_AUDIT_GUARD,
            self::RUNTIME_SMOKE_HARNESS,
            self::DOCUMENTATION_INDEX,
            self::UI_PROVIDER_CANON_GUARD,
            self::FRONTEND_BUILD_GUARD,
            AdminBodyUiProviderCanonContract::CONTRACT_DOC,
            AdminBodyFrontendBuildHardeningContract::CONTRACT_DOC,
        ];
    }

    /** @return list<string> */
    public static function readinessCriteria(): array
    {
        return [
            self::SHELL_CRITERION,
            self::BODY_CRITERION,
            self::PROVIDER_CRITERION,
            self::SCHEMA_CRITERION,
            self::RUNTIME_CRITERION,
            self::RESIDUAL_CRITERION,
            self::DOCS_CRITERION,
            self::UI_PROVIDER_CANON_CRITERION,
            self::FRONTEND_BUILD_CRITERION,
        ];
    }

    /** @return list<list<string>> */
    public static function commandPlan(): array
    {
        return [
            ['php', self::CONSOLIDATED_GUARD],
        ];
    }
}

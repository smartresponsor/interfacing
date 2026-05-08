<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Consolidated guard entrypoints for the admin body RC contract.
 *
 * The consolidated guard is intentionally an orchestrator. It does not replace
 * the lower-level static guards or the runtime smoke harness; it gives CI and
 * local operators one stable command for the complete admin body contract gate.
 */
final readonly class AdminBodyGuardConsolidationContract
{
    public const CONSUMER_PROVIDER_ADOPTION_AUDIT = AdminBodyConsumerProviderAdoptionContract::AUDIT_ENTRYPOINT;

    public const CONSOLIDATED_GUARD_ENTRYPOINT = 'tools/interfacing/admin-body-rc-guard.php';
    public const CONSOLIDATED_GUARD_WRAPPER = 'tools/interfacing/admin-body-rc-guard.ps1';
    public const CONTRACT_DOC = 'docs/interfacing/interfacing-admin-body-guard-consolidation.md';

    public const GUARD_NAME = 'interfacing-admin-body-rc-guard';
    public const GUARD_VERSION = '1.0';

    public const ADMIN_BODY_STATIC_GUARD = 'tools/interfacing/admin-body-mount-contract-guard.php';
    public const SINGLE_ECOSYSTEM_BASE_GUARD = 'tools/interfacing/single-ecosystem-base-guard.php';
    public const RUNTIME_SMOKE_HARNESS = AdminBodyRuntimeSmokeContract::HARNESS_ENTRYPOINT;
    public const RESIDUAL_AUDIT_GUARD = AdminBodyResidualAuditContract::GUARD_ENTRYPOINT;
    public const UI_PROVIDER_CANON_GUARD = AdminBodyUiProviderCanonContract::GUARD_ENTRYPOINT;
    public const FRONTEND_BUILD_GUARD = AdminBodyFrontendBuildHardeningContract::GUARD_ENTRYPOINT;
    public const ECOSYSTEM_UI_COVERAGE_AUDIT = AdminBodyEcommerceUiCoverageContract::AUDIT_ENTRYPOINT;
    public const BRIDGE_PROVIDER_SURFACE_GUARD = 'tools/interfacing/admin-body-bridge-provider-surface-guard.php';

    public const NODE_RUNTIME_ENTRYPOINT = AdminBodyRuntimeContract::ENTRYPOINT;
    public const NODE_SMOKE_ENTRYPOINT = AdminBodyRuntimeSmokeContract::HARNESS_ENTRYPOINT;

    public const FORBIDDEN_CRUDING_ADAPTER = 'cruding_host_adapter';
    public const FORBIDDEN_HOST_COPY_SURFACE = 'templates/bundles/CrudingBundle';
    public const FORBIDDEN_GET_RELATIVE_PATH = 'GetRelativePath';

    /** @return list<string> */
    public static function requiredGuardFiles(): array
    {
        return [
            self::ADMIN_BODY_STATIC_GUARD,
            self::SINGLE_ECOSYSTEM_BASE_GUARD,
            self::RUNTIME_SMOKE_HARNESS,
            self::RESIDUAL_AUDIT_GUARD,
            self::UI_PROVIDER_CANON_GUARD,
            self::FRONTEND_BUILD_GUARD,
            self::ECOSYSTEM_UI_COVERAGE_AUDIT,
            self::BRIDGE_PROVIDER_SURFACE_GUARD,
            self::CONSOLIDATED_GUARD_ENTRYPOINT,
            self::CONSOLIDATED_GUARD_WRAPPER,
        ];
    }

    /** @return list<list<string>> */
    public static function commandPlan(): array
    {
        return [
            ['php', self::ADMIN_BODY_STATIC_GUARD],
            ['php', self::SINGLE_ECOSYSTEM_BASE_GUARD],
            ['node', '--check', self::NODE_RUNTIME_ENTRYPOINT],
            ['node', '--check', self::NODE_SMOKE_ENTRYPOINT],
            ['node', self::RUNTIME_SMOKE_HARNESS],
            ['php', self::RESIDUAL_AUDIT_GUARD],
            ['php', self::UI_PROVIDER_CANON_GUARD],
            ['php', self::FRONTEND_BUILD_GUARD],
            ['php', self::ECOSYSTEM_UI_COVERAGE_AUDIT],
            ['php', self::BRIDGE_PROVIDER_SURFACE_GUARD],
        ];
    }
}

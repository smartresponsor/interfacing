<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Residual cleanup guard for the admin body RC tail.
 *
 * This contract names the final static audit that keeps accidental legacy
 * artifacts out of the Interfacing admin body line before RC promotion. It is
 * intentionally narrow: it checks removed files, deprecated docs, and
 * compatibility-sensitive wrappers without adding another rendering policy.
 */
final readonly class AdminBodyResidualAuditContract
{
    public const GUARD_ENTRYPOINT = 'tools/interfacing/admin-body-residual-audit.php';
    public const GUARD_WRAPPER = 'tools/interfacing/admin-body-residual-audit.ps1';
    public const CONTRACT_DOC = 'docs/interfacing/interfacing-admin-body-residual-audit-cleanup.md';

    public const AUDIT_NAME = 'interfacing-admin-body-residual-audit';
    public const AUDIT_VERSION = '1.0';

    public const FORBIDDEN_CRUDING_ADAPTER_TEMPLATE = 'template/interfacing/crud/bridge/cruding_host_adapter.html.twig';
    public const FORBIDDEN_HOST_SHELL_ADAPTER_TEMPLATE = 'template/interfacing/crud/host_shell_adapter.html.twig';
    public const FORBIDDEN_HOST_COPY_PACK = 'pack/templates/bundles/CrudingBundle';
    public const FORBIDDEN_CRUDING_TEMPLATE_CONTRACT = 'src/Contract/Crud/InterfacingCrudShellTemplateContract.php';
    public const FORBIDDEN_CRUDING_PACK_GUARD = 'tools/interfacing/cruding-host-shell-pack-guard.php';
    public const FORBIDDEN_CRUDING_PACK_GUARD_WRAPPER = 'tools/interfacing/cruding-host-shell-pack-guard.ps1';

    public const FORBIDDEN_BRIDGE_ADOPTION_DOC = 'docs/interfacing/interfacing-cruding-bridge-adoption.md';
    public const FORBIDDEN_HOST_OVERRIDE_PACK_DOC = 'docs/interfacing/interfacing-cruding-host-override-pack.md';
    public const FORBIDDEN_HOST_SHELL_PACK_GUARD_DOC = 'docs/interfacing/interfacing-cruding-host-shell-pack-guard.md';

    public const FORBIDDEN_GET_RELATIVE_PATH = 'GetRelativePath';
    public const REQUIRED_RC_GUARD = AdminBodyGuardConsolidationContract::CONSOLIDATED_GUARD_ENTRYPOINT;

    /** @return list<string> */
    public static function forbiddenPaths(): array
    {
        return [
            self::FORBIDDEN_CRUDING_ADAPTER_TEMPLATE,
            self::FORBIDDEN_HOST_SHELL_ADAPTER_TEMPLATE,
            self::FORBIDDEN_HOST_COPY_PACK,
            self::FORBIDDEN_CRUDING_TEMPLATE_CONTRACT,
            self::FORBIDDEN_CRUDING_PACK_GUARD,
            self::FORBIDDEN_CRUDING_PACK_GUARD_WRAPPER,
            self::FORBIDDEN_BRIDGE_ADOPTION_DOC,
            self::FORBIDDEN_HOST_OVERRIDE_PACK_DOC,
            self::FORBIDDEN_HOST_SHELL_PACK_GUARD_DOC,
        ];
    }

    /** @return list<string> */
    public static function requiredFiles(): array
    {
        return [
            self::GUARD_ENTRYPOINT,
            self::GUARD_WRAPPER,
            self::CONTRACT_DOC,
            self::REQUIRED_RC_GUARD,
            AdminBodyDocumentationContract::CONTRACT_INDEX,
            AdminBodyDocumentationContract::CONSUMER_GUIDE,
        ];
    }
}

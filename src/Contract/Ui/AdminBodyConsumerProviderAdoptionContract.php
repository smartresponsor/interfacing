<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Consumer adoption contract for migrating visible component pages to canonical provider rendering.
 *
 * This contract is intentionally consumer-facing: Interfacing owns the provider canon,
 * while HostHub, Cruding, Vendoring, and other components must adopt it for their
 * visible pages instead of rendering handmade Twig/CSS admin bodies.
 */
final readonly class AdminBodyConsumerProviderAdoptionContract
{
    public const CONTRACT_NAME = 'admin-body-consumer-provider-adoption';
    public const CONTRACT_VERSION = '1.0';

    public const CONTRACT_DOC = 'docs/interfacing/interfacing-visible-page-provider-adoption-audit.md';
    public const AUDIT_ENTRYPOINT = 'tools/interfacing/admin-body-consumer-provider-adoption-audit.php';
    public const AUDIT_WRAPPER = 'tools/interfacing/admin-body-consumer-provider-adoption-audit.ps1';
    public const RUNNER_ENTRYPOINT = 'tools/interfacing/admin-body-consumer-provider-adoption-runner.php';
    public const RUNNER_WRAPPER = 'tools/interfacing/admin-body-consumer-provider-adoption-runner.ps1';

    public const REQUIRED_ADMIN_BODY_INCLUDE = 'interfacing/admin/body/mount.html.twig';
    public const REQUIRED_ADMIN_BODY_MARKER = 'data-interfacing-admin-body-mount';
    public const REQUIRED_RENDERING_MODE = AdminBodyStrictProviderRenderingContract::RENDERING_MODE;

    public const PRIMARY_PROVIDER = AdminBodyUiProviderCanonContract::PRIMARY_PROVIDER;
    public const SECONDARY_PROVIDER = AdminBodyUiProviderCanonContract::SECONDARY_PROVIDER;

    public const FORBIDDEN_BOOTSTRAP_CLASS_PREFIX = 'btn btn-';
    public const FORBIDDEN_BOOTSTRAP_GRID_CONTAINER = 'container-fluid';
    public const FORBIDDEN_INLINE_ADMIN_STYLE = '<style';
    public const FORBIDDEN_HANDMADE_ADMIN_TABLE = '<table';
    public const FORBIDDEN_HOST_COPY_SURFACE = 'templates/bundles/CrudingBundle';
    public const FORBIDDEN_CRUDING_ADAPTER = 'cruding_host_adapter';

    /** @return list<string> */
    public static function requiredFiles(): array
    {
        return [
            self::CONTRACT_DOC,
            self::AUDIT_ENTRYPOINT,
            self::AUDIT_WRAPPER,
            self::RUNNER_ENTRYPOINT,
            self::RUNNER_WRAPPER,
            AdminBodyUiProviderCanonContract::CONTRACT_DOC,
            AdminBodyStrictProviderRenderingContract::CONTRACT_DOC,
        ];
    }

    /** @return list<string> */
    public static function consumerMilestoneTargets(): array
    {
        return [
            'HostHub/App visible pages',
            'Cruding collection/detail/form/delete pages',
            'Vendoring visible pages',
            'Other Smart Responsor component landing/admin pages',
        ];
    }

    /** @return list<string> */
    public static function visiblePageGate(): array
    {
        return [
            'page inherits the shared Interfacing ecosystem shell',
            'admin/workbench body is provider-owned',
            'Ant Design ProComponents renders admin/workbench pages',
            'PrimeReact remains secondary rich-facade provider',
            'Twig does not render handmade admin tables/forms/CSS',
            'Bootstrap is not introduced as a design provider',
            'Cruding is not special-cased with adapters or HostApp copy overrides',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * PrimeReact provider attachment contract for secondary rich facade mounts.
 *
 * Ant Design ProComponents remains the canonical admin/business workbench
 * provider. PrimeReact is registered as a secondary provider for rich facade,
 * inspectors, overlays, and specialized widgets that may be composed around
 * the central admin body without replacing the table-first CRUD discipline.
 */
final readonly class AdminBodyPrimeReactProviderContract
{
    public const PROVIDER_NAME = 'primereact';
    public const ENTRYPOINT = 'interfacing/admin-body/providers/primereact.js';
    public const SCRIPT_MARKER = 'interfacing-admin-body-provider-primereact';
    public const EXTERNAL_PROVIDER_NAME = 'InterfacingPrimeReactAdminBodyProvider';
    public const PROVIDER_MISSING_EVENT = 'interfacing:admin-body:primereact-provider-missing';
    public const PROVIDER_REGISTERED_EVENT = 'interfacing:admin-body:primereact-provider-registered';

    public const REQUIRED_METHOD_MOUNT = 'mount';
}

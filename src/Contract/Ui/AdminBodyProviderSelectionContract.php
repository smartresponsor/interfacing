<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Provider selection policy for hydrated admin body mounts.
 *
 * Ant Design ProComponents is the primary renderer for administrative CRUD,
 * table, and form workbench bodies. PrimeReact is intentionally secondary and
 * may be registered for rich-facade widgets, inspectors, overlays, and side
 * surfaces, but it must not silently replace the table-first admin workbench.
 */
final readonly class AdminBodyProviderSelectionContract
{
    public const PRIMARY_PROVIDER = 'antd-pro';
    public const SECONDARY_PROVIDER = 'primereact';

    public const POLICY_NAME = 'admin-body-provider-selection';
    public const PRIMARY_ROLE = 'admin-workbench';
    public const SECONDARY_ROLE = 'rich-facade';
    public const SECONDARY_REPLACEMENT_MODE = 'forbidden-for-admin-body';

    public const PROVIDER_POLICY_ERROR_EVENT = 'interfacing:admin-body:provider-policy-error';
    public const PROVIDER_REQUIRED_ERROR_EVENT = 'interfacing:admin-body:provider-required-error';

    public const HYDRATION_PROVIDER_POLICY_ERROR = 'provider-policy-error';
    public const HYDRATION_PROVIDER_REQUIRED_ERROR = 'provider-required-error';
}

<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Ant Design ProComponents provider attachment contract for admin body mounts.
 *
 * This contract names the registration-only browser adapter that connects an
 * externally supplied Ant Design ProComponents renderer to the Interfacing
 * admin body provider registry. It intentionally does not implement a fake
 * React renderer.
 */
final readonly class AdminBodyAntDesignProProviderContract
{
    public const PROVIDER_NAME = 'antd-pro';
    public const ENTRYPOINT = 'interfacing/admin-body/providers/antd-pro.js';
    public const SCRIPT_MARKER = 'interfacing-admin-body-provider-antd-pro';
    public const EXTERNAL_PROVIDER_NAME = 'InterfacingAntDesignProAdminBodyProvider';
    public const PROVIDER_MISSING_EVENT = 'interfacing:admin-body:antd-pro-provider-missing';
    public const PROVIDER_REGISTERED_EVENT = 'interfacing:admin-body:antd-pro-provider-registered';

    public const REQUIRED_METHOD_MOUNT = 'mount';
}

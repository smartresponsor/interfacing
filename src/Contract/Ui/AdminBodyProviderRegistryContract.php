<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Browser-side provider registry contract for hydrated admin body renderers.
 *
 * Interfacing owns the shell, mount, schema, and registry handshake. Concrete
 * UI packages register renderers here, for example an Ant Design
 * ProComponents renderer under the canonical `antd-pro` provider key. This
 * class intentionally does not implement a renderer and does not make Twig a
 * replacement design system.
 */
final readonly class AdminBodyProviderRegistryContract
{
    public const ENTRYPOINT = 'interfacing/admin-body/provider-registry.js';
    public const ANTD_PRO_PROVIDER_ENTRYPOINT = 'interfacing/admin-body/providers/antd-pro.js';
    public const PRIMEREACT_PROVIDER_ENTRYPOINT = 'interfacing/admin-body/providers/primereact.js';
    public const REGISTRY_NAME = 'InterfacingAdminBodyProviders';
    public const REGISTRY_API_NAME = 'InterfacingAdminBodyProviderRegistry';

    public const METHOD_REGISTER = 'register';
    public const METHOD_HAS = 'has';
    public const METHOD_GET = 'get';
    public const METHOD_LIST = 'list';

    public const PROVIDER_ANTD_PRO = 'antd-pro';
    public const PROVIDER_PRIMEREACT = 'primereact';
}

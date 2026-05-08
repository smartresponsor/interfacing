<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Canonical navigation and breadcrumb policy for admin body workbench screens.
 *
 * The ecosystem shell owns global navigation. The admin body owns only local
 * resource context: breadcrumbs, back-to-list, scoped resource context, and
 * provider targets that map cleanly to Ant Design ProComponents.
 */
final readonly class AdminBodyNavigationPolicyContract
{
    public const POLICY_NAME = 'admin-body-navigation-policy';
    public const VERSION = '1.0';

    public const BREADCRUMB_PROVIDER_TARGET = 'PageContainer.breadcrumb';
    public const BACK_ACTION_PROVIDER_TARGET = 'PageContainer.extra.back';
    public const RESOURCE_CONTEXT_PROVIDER_TARGET = 'PageContainer.header.resourceContext';
    public const ROUTE_CONTEXT_PROVIDER_TARGET = 'PageContainer.header.routeContext';

    public const ERROR_EVENT = 'interfacing:admin-body:navigation-policy-error';
    public const HYDRATION_ERROR = 'navigation-policy-error';
}

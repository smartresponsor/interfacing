<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Canonical admin body mount contract for Smart Responsor workbench screens.
 *
 * Twig owns the ecosystem shell, the body slot, mount attributes, and schema.
 * The rich CRUD/business workbench belongs to the configured UI
 * provider discipline: Ant Design + ProComponents for table/form/admin
 * workflows, and PrimeReact only for rich facade or specialized widgets.
 */
final readonly class AdminBodyMountContract
{
    public const PROVIDER_ANTD_PRO = 'antd-pro';
    public const SECONDARY_PROVIDER_PRIMEREACT = 'primereact';

    public const PROVIDER_SELECTION_POLICY = 'admin-body-provider-selection';
    public const PROVIDER_PRIMARY_ROLE_ADMIN_WORKBENCH = 'admin-workbench';
    public const PROVIDER_SECONDARY_ROLE_RICH_FACADE = 'rich-facade';
    public const PROVIDER_SECONDARY_REPLACEMENT_MODE = 'forbidden-for-admin-body';

    public const DEFAULT_VIEW_TABLE = 'table';
    public const OPTIONAL_VIEW_CARDS = 'cards';

    public const ADMIN_BODY_SCHEMA = 'interfacing.admin.body';
    public const ADMIN_BODY_SCHEMA_VERSION = '1.0';
    public const ADMIN_BODY_SCHEMA_MANIFEST = 'admin-body-schema-manifest';
    public const ADMIN_BODY_SCHEMA_MANIFEST_VERSION = '1.0';
    public const ADMIN_BODY_PROVIDER_REGISTRY_ENTRYPOINT = 'interfacing/admin-body/provider-registry.js';
    public const ADMIN_BODY_ANTD_PRO_PROVIDER_ENTRYPOINT = 'interfacing/admin-body/providers/antd-pro.js';
    public const ADMIN_BODY_PRIMEREACT_PROVIDER_ENTRYPOINT = 'interfacing/admin-body/providers/primereact.js';
    public const ADMIN_BODY_RUNTIME_ENTRYPOINT = 'interfacing/admin-body/runtime.js';
    public const ADMIN_BODY_READY_EVENT = 'interfacing:admin-body:ready';
    public const ADMIN_BODY_RESOURCE_CONTRACT = 'admin-body-resource-contract';
    public const ADMIN_BODY_RESOURCE_CONTRACT_VERSION = '1.0';
    public const ADMIN_BODY_OPERATION_POLICY = 'admin-body-operation-policy';
    public const ADMIN_BODY_OPERATION_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_TOOLBAR_POLICY = 'admin-body-toolbar-policy';
    public const ADMIN_BODY_TOOLBAR_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_ROW_SELECTION_POLICY = 'admin-body-row-selection-policy';
    public const ADMIN_BODY_ROW_SELECTION_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_TABLE_INTERACTION_POLICY = 'admin-body-table-interaction-policy';
    public const ADMIN_BODY_TABLE_INTERACTION_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_EMPTY_STATE_POLICY = 'admin-body-empty-state-policy';
    public const ADMIN_BODY_EMPTY_STATE_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_FORM_LIFECYCLE_POLICY = 'admin-body-form-lifecycle-policy';
    public const ADMIN_BODY_FORM_LIFECYCLE_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_DETAIL_VIEW_POLICY = 'admin-body-detail-view-policy';
    public const ADMIN_BODY_DETAIL_VIEW_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_NAVIGATION_POLICY = 'admin-body-navigation-policy';
    public const ADMIN_BODY_NAVIGATION_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_AUTHORIZATION_POLICY = 'admin-body-authorization-policy';
    public const ADMIN_BODY_AUTHORIZATION_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_TELEMETRY_POLICY = 'admin-body-telemetry-policy';
    public const ADMIN_BODY_TELEMETRY_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_ACCESSIBILITY_POLICY = 'admin-body-accessibility-policy';
    public const ADMIN_BODY_ACCESSIBILITY_POLICY_VERSION = '1.0';
    public const ADMIN_BODY_RESPONSIVE_LAYOUT_POLICY = 'admin-body-responsive-layout-policy';
    public const ADMIN_BODY_RESPONSIVE_LAYOUT_POLICY_VERSION = '1.0';

    public const MOUNT_TEMPLATE = 'interfacing/admin/body/mount.html.twig';
    public const SCHEMA_TEMPLATE = 'interfacing/admin/body/schema.html.twig';
    public const CRUD_GENERIC_TEMPLATE = 'interfacing/crud/generic.html.twig';

    /** @return list<string> */
    public static function canonicalViewModes(): array
    {
        return [self::DEFAULT_VIEW_TABLE, self::OPTIONAL_VIEW_CARDS];
    }
}

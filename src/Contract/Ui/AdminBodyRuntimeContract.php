<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Frontend handshake contract for admin body hydration.
 *
 * Twig owns the shell and schema markers, not admin body rendering. This contract names the
 * stable Asset Mapper entrypoint, DOM markers, browser event, and provider
 * registry consumed by the Ant Design ProComponents admin/workbench renderer.
 */
final readonly class AdminBodyRuntimeContract
{
    public const ENTRYPOINT = 'interfacing/admin-body/runtime.js';
    public const PROVIDER_REGISTRY_ENTRYPOINT = 'interfacing/admin-body/provider-registry.js';
    public const ANTD_PRO_PROVIDER_ENTRYPOINT = 'interfacing/admin-body/providers/antd-pro.js';
    public const PRIMEREACT_PROVIDER_ENTRYPOINT = 'interfacing/admin-body/providers/primereact.js';
    public const SCRIPT_MARKER = 'interfacing-admin-body-runtime';
    public const READY_EVENT = 'interfacing:admin-body:ready';
    public const SCHEMA_MANIFEST_ERROR_EVENT = 'interfacing:admin-body:schema-manifest-error';
    public const PROVIDER_POLICY_ERROR_EVENT = 'interfacing:admin-body:provider-policy-error';
    public const RESOURCE_CONTRACT_ERROR_EVENT = 'interfacing:admin-body:resource-contract-error';
    public const OPERATION_POLICY_ERROR_EVENT = 'interfacing:admin-body:operation-policy-error';
    public const TOOLBAR_POLICY_ERROR_EVENT = 'interfacing:admin-body:toolbar-policy-error';
    public const ROW_SELECTION_POLICY_ERROR_EVENT = 'interfacing:admin-body:row-selection-policy-error';
    public const TABLE_INTERACTION_POLICY_ERROR_EVENT = 'interfacing:admin-body:table-interaction-policy-error';
    public const EMPTY_STATE_POLICY_ERROR_EVENT = 'interfacing:admin-body:empty-state-policy-error';
    public const FORM_LIFECYCLE_POLICY_ERROR_EVENT = 'interfacing:admin-body:form-lifecycle-policy-error';
    public const DETAIL_VIEW_POLICY_ERROR_EVENT = 'interfacing:admin-body:detail-view-policy-error';
    public const NAVIGATION_POLICY_ERROR_EVENT = 'interfacing:admin-body:navigation-policy-error';
    public const AUTHORIZATION_POLICY_ERROR_EVENT = 'interfacing:admin-body:authorization-policy-error';
    public const TELEMETRY_POLICY_ERROR_EVENT = 'interfacing:admin-body:telemetry-policy-error';
    public const ACCESSIBILITY_POLICY_ERROR_EVENT = 'interfacing:admin-body:accessibility-policy-error';
    public const RESPONSIVE_LAYOUT_POLICY_ERROR_EVENT = 'interfacing:admin-body:responsive-layout-policy-error';
    public const HYDRATION_FAILED_EVENT = 'interfacing:admin-body:hydration-failed';
    public const ACTION_INTENT_EVENT = 'interfacing:admin-body:action-intent';
    public const ACTION_DENIED_EVENT = 'interfacing:admin-body:action-denied';
    public const VIEW_MODE_CHANGED_EVENT = 'interfacing:admin-body:view-mode-changed';
    public const CONTENT_LOCALE_CHANGED_EVENT = 'interfacing:admin-body:content-locale-changed';
    public const SELECTION_CHANGED_EVENT = 'interfacing:admin-body:selection-changed';
    public const FORM_DIRTY_STATE_CHANGED_EVENT = 'interfacing:admin-body:form-dirty-state-changed';
    public const FORM_SUBMIT_INTENT_EVENT = 'interfacing:admin-body:form-submit-intent';
    public const PROVIDER_REQUIRED_ERROR_EVENT = 'interfacing:admin-body:provider-required-error';
    public const PROVIDER_REGISTRY = 'InterfacingAdminBodyProviders';
    public const PROVIDER_REGISTRY_API = 'InterfacingAdminBodyProviderRegistry';
    public const MOUNT_SELECTOR = '[data-interfacing-admin-body-mount="true"]';
    public const SCHEMA_SELECTOR = '[data-interfacing-admin-body-schema="true"]';
    public const HYDRATION_STATE_ATTRIBUTE = 'data-admin-body-hydration';
    public const SMOKE_HARNESS_ENTRYPOINT = 'tools/interfacing/admin-body-runtime-smoke.mjs';
    public const SMOKE_HARNESS_WRAPPER = 'tools/interfacing/admin-body-runtime-smoke.ps1';
    public const SMOKE_SCENARIO_PROVIDER_REQUIRED_ERROR = 'provider-required-error';
    public const SMOKE_SCENARIO_PRIMARY_PROVIDER_READY = 'primary-provider-ready';

    public const HYDRATION_PENDING = 'pending';
    public const HYDRATION_READY = 'ready';
    public const HYDRATION_PROVIDER_REQUIRED_ERROR = 'provider-required-error';
    public const HYDRATION_SCHEMA_MANIFEST_ERROR = 'schema-manifest-error';
    public const HYDRATION_PROVIDER_POLICY_ERROR = 'provider-policy-error';
    public const HYDRATION_RESOURCE_CONTRACT_ERROR = 'resource-contract-error';
    public const HYDRATION_OPERATION_POLICY_ERROR = 'operation-policy-error';
    public const HYDRATION_TOOLBAR_POLICY_ERROR = 'toolbar-policy-error';
    public const HYDRATION_ROW_SELECTION_POLICY_ERROR = 'row-selection-policy-error';
    public const HYDRATION_TABLE_INTERACTION_POLICY_ERROR = 'table-interaction-policy-error';
    public const HYDRATION_EMPTY_STATE_POLICY_ERROR = 'empty-state-policy-error';
    public const HYDRATION_FORM_LIFECYCLE_POLICY_ERROR = 'form-lifecycle-policy-error';
    public const HYDRATION_DETAIL_VIEW_POLICY_ERROR = 'detail-view-policy-error';
    public const HYDRATION_NAVIGATION_POLICY_ERROR = 'navigation-policy-error';
    public const HYDRATION_AUTHORIZATION_POLICY_ERROR = 'authorization-policy-error';
    public const HYDRATION_TELEMETRY_POLICY_ERROR = 'telemetry-policy-error';
    public const HYDRATION_ACCESSIBILITY_POLICY_ERROR = 'accessibility-policy-error';
    public const HYDRATION_RESPONSIVE_LAYOUT_POLICY_ERROR = 'responsive-layout-policy-error';
    public const HYDRATION_SCHEMA_ERROR = 'schema-error';
}

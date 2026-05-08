<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Machine-readable schema contract for hydrated admin body workbenches.
 *
 * The Twig mount remains the shell/body entry point. This contract names the
 * JSON payload and keys consumed by the future Ant Design ProComponents layer
 * so CRUD pages do not drift into ad hoc data attributes or native-Twig-only
 * admin screens.
 */
final readonly class AdminBodySchemaContract
{
    public const SCRIPT_TYPE = 'application/json';
    public const SCRIPT_MARKER = 'interfacing-admin-body-schema';
    public const TEMPLATE = 'interfacing/admin/body/schema.html.twig';

    public const KEY_SCHEMA = 'schema';
    public const KEY_VERSION = 'version';
    public const KEY_PROVIDERS = 'providers';
    public const KEY_SCHEMA_MANIFEST = 'schemaManifest';
    public const KEY_RESOURCE = 'resource';
    public const KEY_RESOURCE_CONTRACT = 'resourceContract';
    public const KEY_OPERATION_POLICY = 'operationPolicy';
    public const KEY_TOOLBAR_POLICY = 'toolbarPolicy';
    public const KEY_ROW_SELECTION_POLICY = 'rowSelectionPolicy';
    public const KEY_TABLE_INTERACTION_POLICY = 'tableInteractionPolicy';
    public const KEY_EMPTY_STATE_POLICY = 'emptyStatePolicy';
    public const KEY_FORM_LIFECYCLE_POLICY = 'formLifecyclePolicy';
    public const KEY_DETAIL_VIEW_POLICY = 'detailViewPolicy';
    public const KEY_NAVIGATION_POLICY = 'navigationPolicy';
    public const KEY_AUTHORIZATION_POLICY = 'authorizationPolicy';
    public const KEY_TELEMETRY_POLICY = 'telemetryPolicy';
    public const KEY_ACCESSIBILITY_POLICY = 'accessibilityPolicy';
    public const KEY_RESPONSIVE_LAYOUT_POLICY = 'responsiveLayoutPolicy';
    public const KEY_OPERATION = 'operation';
    public const KEY_SURFACE = 'surface';
    public const KEY_VIEW = 'view';
    public const KEY_LOCALE = 'locale';
    public const KEY_TOOLBAR = 'toolbar';
    public const KEY_TABLE = 'table';
    public const KEY_CARDS = 'cards';
    public const KEY_FORM = 'form';
    public const KEY_ACTIONS = 'actions';
    public const KEY_RUNTIME = 'runtime';
    public const KEY_PROVIDER_POLICY = 'providerPolicy';
    public const KEY_HYDRATION = 'hydration';

    public const VERSION = '1.0';

    /** @return list<string> */
    public static function requiredTopLevelKeys(): array
    {
        return [
            self::KEY_SCHEMA,
            self::KEY_VERSION,
            self::KEY_PROVIDERS,
            self::KEY_SCHEMA_MANIFEST,
            self::KEY_RESOURCE,
            self::KEY_RESOURCE_CONTRACT,
            self::KEY_OPERATION_POLICY,
            self::KEY_TOOLBAR_POLICY,
            self::KEY_ROW_SELECTION_POLICY,
            self::KEY_TABLE_INTERACTION_POLICY,
            self::KEY_EMPTY_STATE_POLICY,
            self::KEY_FORM_LIFECYCLE_POLICY,
            self::KEY_DETAIL_VIEW_POLICY,
            self::KEY_NAVIGATION_POLICY,
            self::KEY_AUTHORIZATION_POLICY,
            self::KEY_TELEMETRY_POLICY,
            self::KEY_ACCESSIBILITY_POLICY,
            self::KEY_RESPONSIVE_LAYOUT_POLICY,
            self::KEY_OPERATION,
            self::KEY_SURFACE,
            self::KEY_VIEW,
            self::KEY_LOCALE,
            self::KEY_TOOLBAR,
            self::KEY_TABLE,
            self::KEY_CARDS,
            self::KEY_FORM,
            self::KEY_ACTIONS,
            self::KEY_RUNTIME,
            self::KEY_PROVIDER_POLICY,
            self::KEY_HYDRATION,
        ];
    }
}

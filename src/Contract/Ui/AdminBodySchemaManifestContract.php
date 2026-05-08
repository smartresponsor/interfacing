<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Consolidated index for the admin body schema payload.
 *
 * The admin body schema intentionally contains many narrow policy sections.
 * This manifest is the stable table of contents used by guards, the runtime,
 * and future Ant Design ProComponents renderers to understand which sections
 * are required for the current schema version.
 */
final readonly class AdminBodySchemaManifestContract
{
    public const KEY_SCHEMA_MANIFEST = 'schemaManifest';
    public const MANIFEST_NAME = 'admin-body-schema-manifest';
    public const MANIFEST_VERSION = '1.0';
    public const SCHEMA_NAME = 'interfacing.admin.body';
    public const SCHEMA_VERSION = '1.0';
    public const OWNER = 'interfacing-admin-body-contract';

    /** @return list<string> */
    public static function requiredPolicyKeys(): array
    {
        return [
            AdminBodySchemaContract::KEY_PROVIDER_POLICY,
            AdminBodySchemaContract::KEY_RESOURCE_CONTRACT,
            AdminBodySchemaContract::KEY_OPERATION_POLICY,
            AdminBodySchemaContract::KEY_TOOLBAR_POLICY,
            AdminBodySchemaContract::KEY_ROW_SELECTION_POLICY,
            AdminBodySchemaContract::KEY_TABLE_INTERACTION_POLICY,
            AdminBodySchemaContract::KEY_EMPTY_STATE_POLICY,
            AdminBodySchemaContract::KEY_FORM_LIFECYCLE_POLICY,
            AdminBodySchemaContract::KEY_DETAIL_VIEW_POLICY,
            AdminBodySchemaContract::KEY_NAVIGATION_POLICY,
            AdminBodySchemaContract::KEY_AUTHORIZATION_POLICY,
            AdminBodySchemaContract::KEY_TELEMETRY_POLICY,
            AdminBodySchemaContract::KEY_ACCESSIBILITY_POLICY,
            AdminBodySchemaContract::KEY_RESPONSIVE_LAYOUT_POLICY,
        ];
    }
}

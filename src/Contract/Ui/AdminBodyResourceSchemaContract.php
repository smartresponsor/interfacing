<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Resource-level admin body schema contract for CRUD/business workbenches.
 *
 * This contract names the provider-neutral payload that the Ant Design
 * ProComponents renderer consumes for ProTable columns, action column,
 * toolbar filters, and ProForm fields. Twig remains a schema/mount publisher only.
 */
final readonly class AdminBodyResourceSchemaContract
{
    public const KEY_RESOURCE_CONTRACT = 'resourceContract';
    public const KEY_DATA_SOURCE = 'dataSource';
    public const KEY_COLUMNS = 'columns';
    public const KEY_FILTERS = 'filters';
    public const KEY_FORM_FIELDS = 'formFields';
    public const KEY_HEADER_ACTIONS = 'headerActions';
    public const KEY_ROW_ACTIONS = 'rowActions';

    public const CONTRACT_NAME = 'admin-body-resource-contract';
    public const VERSION = '1.0';
    public const PROVIDER_TARGET_PRO_TABLE = 'ProTable';
    public const PROVIDER_TARGET_PRO_FORM = 'ProForm';
    public const ACTION_COLUMN_KEY = 'actions';
    public const DEFAULT_ROW_KEY = 'id';

    /** @return list<string> */
    public static function requiredResourceContractKeys(): array
    {
        return [
            self::KEY_DATA_SOURCE,
            self::KEY_COLUMNS,
            self::KEY_FILTERS,
            self::KEY_FORM_FIELDS,
            self::KEY_HEADER_ACTIONS,
            self::KEY_ROW_ACTIONS,
        ];
    }
}

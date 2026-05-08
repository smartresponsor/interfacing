<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Row-selection policy for admin body workbench screens.
 *
 * Bulk actions must not appear as an ad hoc toolbar control. They are enabled
 * only through an explicit row-selection contract that maps to Ant Design
 * ProComponents table row selection and tableAlertOption surfaces.
 */
final readonly class AdminBodyRowSelectionPolicyContract
{
    public const KEY_ROW_SELECTION_POLICY = 'rowSelectionPolicy';

    public const CONTRACT_NAME = 'admin-body-row-selection-policy';
    public const VERSION = '1.0';

    public const ROW_KEY = 'id';
    public const SELECTION_TYPE_CHECKBOX = 'checkbox';
    public const DEFAULT_MODE = 'disabled-until-provider-selection-state';
    public const BULK_ACTIONS_MODE = 'guarded-by-row-selection';

    public const PROVIDER_TARGET_ROW_SELECTION = 'ProTable.rowSelection';
    public const PROVIDER_TARGET_TABLE_ALERT_OPTION = 'ProTable.tableAlertOption';
    public const PROVIDER_TARGET_BULK_ACTIONS = 'ProTable.tableAlertOption.bulkActions';

    public const BULK_ACTION_DELETE = 'delete-selected';
    public const BULK_ACTION_EXPORT = 'export-selected';

    /** @return list<string> */
    public static function requiredRowSelectionPolicyKeys(): array
    {
        return [
            'name',
            'version',
            'enabled',
            'rowKey',
            'selectionType',
            'mode',
            'bulkActions',
            'providerTargets',
        ];
    }

    /** @return list<string> */
    public static function guardedBulkActions(): array
    {
        return [
            self::BULK_ACTION_DELETE,
            self::BULK_ACTION_EXPORT,
        ];
    }
}

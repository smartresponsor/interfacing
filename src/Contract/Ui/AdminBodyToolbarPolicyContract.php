<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Toolbar policy for admin body workbench screens.
 *
 * The toolbar is part of the central admin body discipline, not the ecosystem
 * shell. It declares the stable Ant Design ProComponents-oriented controls
 * that a CRUD/workbench renderer must understand: search, filters, content
 * locale, table/card view mode, and explicit bulk-action policy.
 */
final readonly class AdminBodyToolbarPolicyContract
{
    public const KEY_TOOLBAR_POLICY = 'toolbarPolicy';

    public const CONTRACT_NAME = 'admin-body-toolbar-policy';
    public const VERSION = '1.0';

    public const CONTROL_SEARCH = 'search';
    public const CONTROL_FILTERS = 'filters';
    public const CONTROL_CONTENT_LOCALE = 'content-locale';
    public const CONTROL_VIEW_MODE = 'view-mode';
    public const CONTROL_BULK_ACTIONS = 'bulk-actions';

    public const SEARCH_PLACEMENT = 'pro-table-toolbar-search';
    public const FILTERS_PLACEMENT = 'pro-table-search-form';
    public const LOCALE_PLACEMENT = 'toolbar-extra-content-locale';
    public const VIEW_MODE_PLACEMENT = 'toolbar-extra-view-mode';
    public const BULK_ACTIONS_PLACEMENT = 'pro-table-alert-option';

    public const SEARCH_PROVIDER_TARGET = 'ProTable.toolbar.search';
    public const FILTERS_PROVIDER_TARGET = 'ProTable.search';
    public const LOCALE_PROVIDER_TARGET = 'PageContainer.extra.contentLocale';
    public const VIEW_MODE_PROVIDER_TARGET = 'PageContainer.extra.viewMode';
    public const BULK_ACTIONS_PROVIDER_TARGET = 'ProTable.tableAlertOption';

    public const BULK_ACTIONS_DEFAULT_MODE = 'guarded-by-row-selection';

    /** @return list<string> */
    public static function requiredToolbarPolicyKeys(): array
    {
        return [
            'name',
            'version',
            'controls',
            'search',
            'filters',
            'contentLocale',
            'viewMode',
            'bulkActions',
            'providerTargets',
        ];
    }

    /** @return list<string> */
    public static function canonicalControls(): array
    {
        return [
            self::CONTROL_SEARCH,
            self::CONTROL_FILTERS,
            self::CONTROL_CONTENT_LOCALE,
            self::CONTROL_VIEW_MODE,
            self::CONTROL_BULK_ACTIONS,
        ];
    }
}

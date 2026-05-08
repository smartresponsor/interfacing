<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Table interaction policy for admin body workbench screens.
 *
 * Collection screens are table-first. Pagination, sorting, and density controls
 * must be explicit ProTable concerns rather than ad hoc Twig links or bespoke
 * JavaScript behavior.
 */
final readonly class AdminBodyTableInteractionPolicyContract
{
    public const KEY_TABLE_INTERACTION_POLICY = 'tableInteractionPolicy';

    public const CONTRACT_NAME = 'admin-body-table-interaction-policy';
    public const VERSION = '1.0';

    public const PAGINATION_MODE_SERVER_DRIVEN = 'server-driven';
    public const SORTING_MODE_SERVER_DRIVEN = 'server-driven';

    public const PAGE_PARAM = 'page';
    public const PAGE_SIZE_PARAM = 'pageSize';
    public const SORT_PARAM = 'sort';
    public const SORT_DIRECTION_PARAM = 'direction';

    public const DIRECTION_ASC = 'asc';
    public const DIRECTION_DESC = 'desc';

    public const DENSITY_SMALL = 'small';
    public const DENSITY_MIDDLE = 'middle';
    public const DENSITY_LARGE = 'large';

    public const PROVIDER_TARGET_PAGINATION = 'ProTable.pagination';
    public const PROVIDER_TARGET_SORTING = 'ProTable.columns.sorter';
    public const PROVIDER_TARGET_DENSITY = 'ProTable.options';

    /** @return list<string> */
    public static function requiredTableInteractionPolicyKeys(): array
    {
        return [
            'name',
            'version',
            'pagination',
            'sorting',
            'density',
            'providerTargets',
        ];
    }

    /** @return list<string> */
    public static function canonicalSortDirections(): array
    {
        return [self::DIRECTION_ASC, self::DIRECTION_DESC];
    }

    /** @return list<string> */
    public static function canonicalDensityOptions(): array
    {
        return [self::DENSITY_SMALL, self::DENSITY_MIDDLE, self::DENSITY_LARGE];
    }
}

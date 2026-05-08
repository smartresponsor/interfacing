<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Responsive layout and density contract for admin body workbenches.
 *
 * The ecosystem shell owns the outer frame. This policy describes how the
 * central Ant Design ProComponents admin body should adapt ProTable, ProForm,
 * cards, toolbar, and detail views across desktop, tablet, and mobile without
 * inventing a separate mobile-only Twig UI.
 */
final readonly class AdminBodyResponsiveLayoutPolicyContract
{
    public const POLICY_NAME = 'admin-body-responsive-layout-policy';
    public const VERSION = '1.0';

    public const MODE = 'provider-native-responsive-layout';
    public const SHELL_OWNER = 'ecosystem-shell';
    public const BODY_OWNER = 'ant-design-procomponents';

    public const BREAKPOINT_DESKTOP = 'desktop';
    public const BREAKPOINT_TABLET = 'tablet';
    public const BREAKPOINT_MOBILE = 'mobile';

    public const DENSITY_DEFAULT = 'middle';
    public const DENSITY_COMPACT = 'small';
    public const DENSITY_COMFORTABLE = 'large';

    public const TABLE_SCROLL_MODE = 'horizontal-scroll-on-narrow';
    public const CARD_SECONDARY_MODE = 'cards-allowed-on-narrow';
    public const FILTER_COLLAPSE_MODE = 'collapse-filters-on-narrow';
    public const FORM_LAYOUT_MODE = 'vertical-on-narrow';

    public const PROVIDER_TARGET_PAGE = 'PageContainer';
    public const PROVIDER_TARGET_TABLE = 'ProTable';
    public const PROVIDER_TARGET_TABLE_SCROLL = 'ProTable.scroll';
    public const PROVIDER_TARGET_TABLE_OPTIONS = 'ProTable.options';
    public const PROVIDER_TARGET_SEARCH_FORM = 'ProTable.search';
    public const PROVIDER_TARGET_FORM = 'ProForm.layout';
    public const PROVIDER_TARGET_CARD_GRID = 'ProCard.grid';
    public const PROVIDER_TARGET_DESCRIPTIONS = 'Descriptions.column';

    public const ERROR_EVENT = 'interfacing:admin-body:responsive-layout-policy-error';
    public const HYDRATION_ERROR = 'responsive-layout-policy-error';
}

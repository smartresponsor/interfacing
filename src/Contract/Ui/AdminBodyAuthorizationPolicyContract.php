<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * UI authorization/visibility contract for admin body actions.
 *
 * Backend voters, access-control rules, and controllers remain authoritative.
 * This contract only standardizes how the hydrated provider
 * expose create/view/edit/delete/bulk/form actions inside the central body.
 */
final readonly class AdminBodyAuthorizationPolicyContract
{
    public const POLICY_NAME = 'admin-body-authorization-policy';
    public const VERSION = '1.0';

    public const ENFORCEMENT_OWNER = 'backend-security-voters';
    public const UI_RESPONSIBILITY = 'visibility-and-disabled-state-only';
    public const DEFAULT_DECISION = 'disabled-until-authorized';
    public const MODE = 'server-declared-action-state';

    public const PROVIDER_TARGET_PAGE_ACTIONS = 'PageContainer.extra';
    public const PROVIDER_TARGET_ROW_ACTIONS = 'ProTable.actionColumn';
    public const PROVIDER_TARGET_BULK_ACTIONS = 'ProTable.tableAlertOption.bulkActions';
    public const PROVIDER_TARGET_FORM_ACTIONS = 'ProForm.submitter';
    public const PROVIDER_TARGET_DISABLED_REASON = 'Tooltip.disabledReason';

    public const AUTHORIZATION_POLICY_ERROR_EVENT = 'interfacing:admin-body:authorization-policy-error';
    public const HYDRATION_AUTHORIZATION_POLICY_ERROR = 'authorization-policy-error';

    /** @return list<string> */
    public static function guardedActionGroups(): array
    {
        return ['headerActions', 'rowActions', 'bulkActions', 'formActions', 'detailActions'];
    }
}

<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Operation/action policy contract for admin body CRUD workbenches.
 *
 * The resource schema describes what can be displayed. This policy describes
 * how CRUD operations are allowed to behave in the hydrated Ant Design
 * ProComponents renderer.
 */
final readonly class AdminBodyOperationPolicyContract
{
    public const KEY_OPERATION_POLICY = 'operationPolicy';
    public const CONTRACT_NAME = 'admin-body-operation-policy';
    public const VERSION = '1.0';

    public const OPERATION_OVERVIEW = 'overview';
    public const OPERATION_INDEX = 'index';
    public const OPERATION_SHOW = 'show';
    public const OPERATION_NEW = 'new';
    public const OPERATION_EDIT = 'edit';
    public const OPERATION_DELETE = 'delete';

    public const ACTION_CREATE = 'create';
    public const ACTION_VIEW = 'view';
    public const ACTION_EDIT = 'edit';
    public const ACTION_DELETE = 'delete';

    public const DELETE_CONFIRMATION_REQUIRED = 'confirmation-required';
    public const DELETE_RENDERING_PATTERN = 'danger-action-with-confirmation';
    public const ACTION_PLACEMENT_HEADER_EXTRA = 'page-header-extra';
    public const ACTION_PLACEMENT_ROW_ACTION_COLUMN = 'action-column';

    /** @return list<string> */
    public static function supportedOperations(): array
    {
        return [
            self::OPERATION_OVERVIEW,
            self::OPERATION_INDEX,
            self::OPERATION_SHOW,
            self::OPERATION_NEW,
            self::OPERATION_EDIT,
            self::OPERATION_DELETE,
        ];
    }

    /** @return list<string> */
    public static function requiredOperationPolicyKeys(): array
    {
        return [
            'name',
            'version',
            'supportedOperations',
            'currentOperation',
            'headerActions',
            'rowActions',
            'destructiveActions',
            'confirmation',
            'providerTargets',
        ];
    }
}

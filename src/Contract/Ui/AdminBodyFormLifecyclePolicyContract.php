<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Form lifecycle policy for admin body workbench screens.
 *
 * Create and edit flows must expose predictable submit, save-and-continue,
 * cancel, dirty-state, validation, and success/error feedback semantics. Twig
 * publishes the schema/mount contract; Ant Design ProComponents should map
 * this policy to ProForm submitter, validation feedback, Modal.confirm, and
 * notification/message primitives.
 */
final readonly class AdminBodyFormLifecyclePolicyContract
{
    public const KEY_FORM_LIFECYCLE_POLICY = 'formLifecyclePolicy';

    public const CONTRACT_NAME = 'admin-body-form-lifecycle-policy';
    public const VERSION = '1.0';

    public const MODE_CREATE = 'create';
    public const MODE_EDIT = 'edit';

    public const ACTION_SAVE = 'save';
    public const ACTION_SAVE_AND_CONTINUE = 'save-and-continue';
    public const ACTION_CANCEL = 'cancel';
    public const ACTION_RESET = 'reset';

    public const DIRTY_STATE_GUARD = 'confirm-on-navigate-away';
    public const VALIDATION_MODE_PROVIDER_NATIVE = 'provider-native';
    public const SUBMIT_MODE_SERVER_DRIVEN = 'server-driven';

    public const PROVIDER_TARGET_FORM = 'ProForm';
    public const PROVIDER_TARGET_SUBMITTER = 'ProForm.submitter';
    public const PROVIDER_TARGET_VALIDATION = 'ProForm.validation';
    public const PROVIDER_TARGET_DIRTY_CONFIRM = 'Modal.confirm';
    public const PROVIDER_TARGET_SUCCESS = 'message.success';
    public const PROVIDER_TARGET_ERROR = 'message.error';

    /** @return list<string> */
    public static function requiredFormLifecyclePolicyKeys(): array
    {
        return [
            'name',
            'version',
            'modes',
            'submit',
            'actions',
            'dirtyState',
            'validation',
            'feedback',
            'providerTargets',
        ];
    }

    /** @return list<string> */
    public static function canonicalActions(): array
    {
        return [
            self::ACTION_SAVE,
            self::ACTION_SAVE_AND_CONTINUE,
            self::ACTION_CANCEL,
            self::ACTION_RESET,
        ];
    }
}

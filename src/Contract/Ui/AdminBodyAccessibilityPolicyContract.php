<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Accessibility and keyboard discipline for admin body workbench screens.
 *
 * The actual ARIA implementation is rendered by the configured provider
 * (Ant Design ProComponents for admin workbenches). Twig publishes the
 * machine-readable policy and a provider-required policy so the central body
 * never drifts into inaccessible ad hoc controls.
 */
final readonly class AdminBodyAccessibilityPolicyContract
{
    public const POLICY_NAME = 'admin-body-accessibility-policy';
    public const VERSION = '1.0';

    public const MODE = 'provider-native-required';
    public const OWNER = 'interfacing-admin-body-provider';
    public const ERROR_EVENT = 'interfacing:admin-body:accessibility-policy-error';

    public const LANDMARK_MAIN = 'main';
    public const TOOLBAR_ROLE = 'toolbar';
    public const TABLE_ROLE = 'table';
    public const FORM_ROLE = 'form';
    public const DETAIL_ROLE = 'region';

    public const KEYBOARD_NAVIGATION = 'keyboard-navigation-required';
    public const FOCUS_RESTORE = 'restore-focus-after-action';
    public const ANNOUNCE_HYDRATION = 'announce-hydration-state';
}

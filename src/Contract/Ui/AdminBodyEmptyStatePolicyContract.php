<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Empty/loading/error state policy for admin body workbench screens.
 *
 * ProTable and ProForm screens must expose predictable empty, loading, API
 * error, validation error, and offline/degraded states. Twig keeps a modest
 * provider-required, but the canonical provider renderer should map this policy to
 * provider-native Result, Empty, Spin, Alert, and Form feedback primitives.
 */
final readonly class AdminBodyEmptyStatePolicyContract
{
    public const KEY_EMPTY_STATE_POLICY = 'emptyStatePolicy';

    public const CONTRACT_NAME = 'admin-body-empty-state-policy';
    public const VERSION = '1.0';

    public const STATE_EMPTY = 'empty';
    public const STATE_LOADING = 'loading';
    public const STATE_ERROR = 'error';
    public const STATE_VALIDATION_ERROR = 'validation-error';
    public const STATE_OFFLINE = 'offline';

    public const EMPTY_STATE_RENDERER = 'ProTable.locale.emptyText';
    public const LOADING_STATE_RENDERER = 'ProTable.loading';
    public const ERROR_STATE_RENDERER = 'Result.error';
    public const VALIDATION_STATE_RENDERER = 'ProForm.validation';
    public const OFFLINE_STATE_RENDERER = 'Alert.offline';

    public const RETRY_ACTION = 'retry';
    public const RESET_FILTERS_ACTION = 'reset-filters';
    public const CREATE_ACTION = 'create';

    /** @return list<string> */
    public static function requiredEmptyStatePolicyKeys(): array
    {
        return [
            'name',
            'version',
            'states',
            'actions',
            'providerTargets',
        ];
    }

    /** @return list<string> */
    public static function canonicalStates(): array
    {
        return [
            self::STATE_EMPTY,
            self::STATE_LOADING,
            self::STATE_ERROR,
            self::STATE_VALIDATION_ERROR,
            self::STATE_OFFLINE,
        ];
    }
}

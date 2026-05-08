<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * UI telemetry policy for hydrated admin body screens.
 *
 * This contract is intentionally renderer-neutral. It does not replace backend
 * audit logs or security events. It names the browser-side UI events that an
 * Ant Design ProComponents renderer may emit for hydration, view switching,
 * locale switching, CRUD actions, form lifecycle, and degraded provider-required states.
 */
final readonly class AdminBodyTelemetryPolicyContract
{
    public const POLICY_NAME = 'admin-body-telemetry-policy';
    public const VERSION = '1.0';

    public const MODE = 'browser-ui-events';
    public const OWNER = 'interfacing-admin-body-runtime';
    public const BACKEND_AUDIT_OWNER = 'backend-audit-log';

    public const EVENT_HYDRATION_READY = 'interfacing:admin-body:ready';
    public const EVENT_HYDRATION_FAILED = 'interfacing:admin-body:hydration-failed';
    public const EVENT_PROVIDER_MISSING = 'interfacing:admin-body:provider-required-error';
    public const EVENT_ACTION_INTENT = 'interfacing:admin-body:action-intent';
    public const EVENT_ACTION_DENIED = 'interfacing:admin-body:action-denied';
    public const EVENT_VIEW_MODE_CHANGED = 'interfacing:admin-body:view-mode-changed';
    public const EVENT_CONTENT_LOCALE_CHANGED = 'interfacing:admin-body:content-locale-changed';
    public const EVENT_SELECTION_CHANGED = 'interfacing:admin-body:selection-changed';
    public const EVENT_FORM_DIRTY_STATE_CHANGED = 'interfacing:admin-body:form-dirty-state-changed';
    public const EVENT_FORM_SUBMIT_INTENT = 'interfacing:admin-body:form-submit-intent';

    public const REQUIRED_DETAIL_RESOURCE = 'resource';
    public const REQUIRED_DETAIL_OPERATION = 'operation';
    public const REQUIRED_DETAIL_SURFACE = 'surface';
    public const REQUIRED_DETAIL_PROVIDER = 'provider';
    public const REQUIRED_DETAIL_HYDRATION = 'hydration';

    /** @return list<string> */
    public static function requiredDetailKeys(): array
    {
        return [
            self::REQUIRED_DETAIL_RESOURCE,
            self::REQUIRED_DETAIL_OPERATION,
            self::REQUIRED_DETAIL_SURFACE,
            self::REQUIRED_DETAIL_PROVIDER,
            self::REQUIRED_DETAIL_HYDRATION,
        ];
    }

    /** @return list<string> */
    public static function eventNames(): array
    {
        return [
            self::EVENT_HYDRATION_READY,
            self::EVENT_HYDRATION_FAILED,
            self::EVENT_PROVIDER_MISSING,
            self::EVENT_ACTION_INTENT,
            self::EVENT_ACTION_DENIED,
            self::EVENT_VIEW_MODE_CHANGED,
            self::EVENT_CONTENT_LOCALE_CHANGED,
            self::EVENT_SELECTION_CHANGED,
            self::EVENT_FORM_DIRTY_STATE_CHANGED,
            self::EVENT_FORM_SUBMIT_INTENT,
        ];
    }
}

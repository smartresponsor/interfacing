<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Contract for the frontend runtime smoke harness.
 *
 * The smoke harness exercises the browser-side admin body handshake without
 * providing a fake renderer UI. It verifies the registry/runtime contract,
 * provider-required-error state, and successful provider mount state.
 */
final readonly class AdminBodyRuntimeSmokeContract
{
    public const HARNESS_ENTRYPOINT = 'tools/interfacing/admin-body-runtime-smoke.mjs';
    public const WRAPPER_ENTRYPOINT = 'tools/interfacing/admin-body-runtime-smoke.ps1';
    public const SCENARIO_PROVIDER_REQUIRED_ERROR = 'provider-required-error';
    public const SCENARIO_PRIMARY_PROVIDER_READY = 'primary-provider-ready';
    public const EXPECTED_MISSING_HYDRATION = 'provider-required-error';
    public const EXPECTED_READY_HYDRATION = 'ready';
    public const EXPECTED_READY_EVENT = 'interfacing:admin-body:ready';
    public const EXPECTED_MISSING_EVENT = 'interfacing:admin-body:provider-required-error';
}

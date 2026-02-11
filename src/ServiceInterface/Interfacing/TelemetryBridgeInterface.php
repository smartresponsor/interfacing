<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing;

use App\Domain\Interfacing\Model\TelemetryEvent;

/**
 *
 */

/**
 *
 */
interface TelemetryBridgeInterface
{
    /**
     * @param \App\Domain\Interfacing\Model\TelemetryEvent $event
     * @return void
     */
    public function emit(TelemetryEvent $event): void;
}

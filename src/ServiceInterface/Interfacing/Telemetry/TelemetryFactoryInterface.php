<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Telemetry;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Telemetry\TelemetryInterface;

interface TelemetryFactoryInterface
{
    public function create(): TelemetryInterface;
}

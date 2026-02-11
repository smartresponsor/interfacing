<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\ServiceInterface\Interfacing\Telemetry;

use App\DomainInterface\Interfacing\Telemetry\TelemetryInterface;

interface TelemetryFactoryInterface
{
    public function create(): TelemetryInterface;
}

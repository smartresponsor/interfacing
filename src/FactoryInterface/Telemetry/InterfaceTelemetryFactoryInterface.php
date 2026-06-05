<?php

declare(strict_types=1);

namespace App\Interfacing\FactoryInterface\Telemetry;

use App\Interfacing\TelemetryInterface\InterfaceEventTelemetryInterface;

interface InterfaceTelemetryFactoryInterface
{
    public function create(): InterfaceEventTelemetryInterface;
}

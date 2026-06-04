<?php

declare(strict_types=1);

namespace App\Interfacing\FactoryInterface\Telemetry;

interface InterfaceTelemetryFactoryInterface
{
    public function create(): InterfaceEventTelemetryInterface;
}

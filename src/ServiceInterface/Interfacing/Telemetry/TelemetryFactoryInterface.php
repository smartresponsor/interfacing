<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Telemetry;

interface TelemetryFactoryInterface
{
    public function create(): TelemetryInterface;
}

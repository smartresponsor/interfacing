<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing;

use App\Domain\Interfacing\Model\TelemetryEvent;

interface TelemetryBridgeInterface
{
    public function emit(TelemetryEvent $event): void;
}

<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Emitter\Telemetry;

use App\Interfacing\Contract\Telemetry\InterfaceTelemetryEvent;
use App\Interfacing\EmitterInterface\Telemetry\InterfaceTelemetryEmitterInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class InterfaceSymfonyEventTelemetryEmitter implements InterfaceTelemetryEmitterInterface
{
    public const EVENT_NAME = 'interfacing.telemetry';

    public function __construct(private readonly EventDispatcherInterface $dispatcher)
    {
    }

    public function emit(InterfaceTelemetryEvent $event): void
    {
        $this->dispatcher->dispatch($event, self::EVENT_NAME);
    }
}

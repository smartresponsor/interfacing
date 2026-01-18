<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Service\Interfacing;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\TelemetryEvent;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\TelemetryBridgeInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class SymfonyEventTelemetryBridge implements TelemetryBridgeInterface
{
    public const EVENT_NAME = 'interfacing.telemetry';

    public function __construct(private EventDispatcherInterface $dispatcher) {}

    public function emit(TelemetryEvent $event): void
    {
        $this->dispatcher->dispatch($event, self::EVENT_NAME);
    }
}

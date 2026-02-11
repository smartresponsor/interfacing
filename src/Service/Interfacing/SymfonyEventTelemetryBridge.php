<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing;

use App\Domain\Interfacing\Model\TelemetryEvent;
use App\ServiceInterface\Interfacing\TelemetryBridgeInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 *
 */

/**
 *
 */
final class SymfonyEventTelemetryBridge implements TelemetryBridgeInterface
{
    public const EVENT_NAME = 'interfacing.telemetry';

    /**
     * @param \Symfony\Contracts\EventDispatcher\EventDispatcherInterface $dispatcher
     */
    public function __construct(private readonly EventDispatcherInterface $dispatcher) {}

    /**
     * @param \App\Domain\Interfacing\Model\TelemetryEvent $event
     * @return void
     */
    public function emit(TelemetryEvent $event): void
    {
        $this->dispatcher->dispatch($event, self::EVENT_NAME);
    }
}

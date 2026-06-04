<?php

declare(strict_types=1);

namespace App\Interfacing\Sink\Audit;

use App\Interfacing\Contract\Audit\InterfaceAuditEvent;
use App\Interfacing\SinkInterface\Audit\InterfaceAuditSinkInterface;
use Psr\Log\LoggerInterface;

final readonly class InterfaceMonologAuditSink implements InterfaceAuditSinkInterface
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function record(InterfaceAuditEvent $event): void
    {
        $this->logger->info('interfacing.audit', [
            'type' => $event->type->value,
            'at' => $event->atIso8601,
            'tenantId' => $event->tenantId,
            'userId' => $event->userId,
            'screenId' => $event->screenId,
            'actionId' => $event->actionId,
            'data' => $event->data,
        ]);
    }
}

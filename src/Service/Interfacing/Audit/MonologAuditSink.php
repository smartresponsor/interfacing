<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Audit;

use App\Interfacing\ServiceInterface\Support\Audit\AuditSinkInterface;
use App\Interfacing\Support\Audit\AuditEvent;
use Psr\Log\LoggerInterface;

final readonly class MonologAuditSink implements AuditSinkInterface
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function record(AuditEvent $event): void
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

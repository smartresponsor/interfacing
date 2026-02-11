<?php
declare(strict_types=1);

namespace App\Service\Interfacing\Audit;

use App\DomainInterface\Interfacing\Audit\AuditSinkInterface;
use App\Domain\Interfacing\Audit\AuditEvent;
use Psr\Log\LoggerInterface;

final class MonologAuditSink implements AuditSinkInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

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

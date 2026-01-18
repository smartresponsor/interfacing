<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Audit;

use SmartResponsor\Interfacing\Domain\Interfacing\Audit\AuditEvent;

interface AuditSinkInterface
{
    public function record(AuditEvent $event): void;
}

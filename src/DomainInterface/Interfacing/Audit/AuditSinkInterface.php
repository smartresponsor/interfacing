<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Audit;

use App\Domain\Interfacing\Audit\AuditEvent;

interface AuditSinkInterface
{
    public function record(AuditEvent $event): void;
}

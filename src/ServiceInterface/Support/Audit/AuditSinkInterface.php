<?php

declare(strict_types=1);

namespace App\ServiceInterface\Support\Audit;

use App\Support\Audit\AuditEvent;

interface AuditSinkInterface
{
    public function record(AuditEvent $event): void;
}

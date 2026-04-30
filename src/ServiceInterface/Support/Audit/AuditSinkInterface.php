<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Support\Audit;

use App\Interfacing\Support\Audit\AuditEvent;

interface AuditSinkInterface
{
    public function record(AuditEvent $event): void;
}

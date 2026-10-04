<?php

declare(strict_types=1);

namespace App\Interfacing\SinkInterface\Audit;

use App\Interfacing\Event\InterfaceAuditEvent;

interface InterfaceAuditSinkInterface
{
    public function record(InterfaceAuditEvent $event): void;
}

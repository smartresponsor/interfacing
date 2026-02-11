<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Audit;

use App\Domain\Interfacing\Audit\AuditEvent;

/**
 *
 */

/**
 *
 */
interface AuditSinkInterface
{
    /**
     * @param \App\Domain\Interfacing\Audit\AuditEvent $event
     * @return void
     */
    public function record(AuditEvent $event): void;
}

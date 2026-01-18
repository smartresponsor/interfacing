Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Audit;

use App\Domain\Interfacing\Audit\AuditEvent;

interface AuditSinkInterface
{
    public function record(AuditEvent $event): void;
}

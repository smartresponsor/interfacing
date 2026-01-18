Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Audit;

enum AuditEventType: string
{
    case ScreenOpen = 'screen.open';
    case ActionRun = 'action.run';
}

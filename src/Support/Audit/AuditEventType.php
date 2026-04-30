<?php

declare(strict_types=1);

namespace App\Interfacing\Support\Audit;

enum AuditEventType: string
{
    case ScreenOpen = 'screen.open';
    case ActionRun = 'action.run';
}

<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Audit;

enum InterfaceAuditEventType: string
{
    case ScreenOpen = 'screen.open';
    case ActionRun = 'action.run';
}

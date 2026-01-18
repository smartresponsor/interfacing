<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\Domain\Interfacing\Audit;

enum AuditEventType: string
{
    case ScreenOpen = 'screen.open';
    case ActionRun = 'action.run';
}

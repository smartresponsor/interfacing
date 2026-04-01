<?php

declare(strict_types=1);

namespace App\Contract\Zone;

enum UiZone: string
{
    case Facade = 'facade';
    case Workbench = 'workbench';
}

<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Access;

enum InterfaceAccessDecisionCode: string
{
    case Allow = 'allow';
    case Deny = 'deny';
    case Defer = 'defer';
}

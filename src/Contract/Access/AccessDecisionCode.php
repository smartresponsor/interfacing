<?php

declare(strict_types=1);

namespace App\Contract\Access;

enum AccessDecisionCode: string
{
    case Allow = 'allow';
    case Deny = 'deny';
    case Defer = 'defer';
}

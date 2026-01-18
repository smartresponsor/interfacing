<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\Domain\Interfacing\Access;

enum AccessDecisionCode: string
{
    case Allow = 'allow';
    case Deny = 'deny';
    case Defer = 'defer';
}

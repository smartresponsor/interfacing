Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Access;

enum AccessDecisionCode: string
{
    case Allow = 'allow';
    case Deny = 'deny';
    case Defer = 'defer';
}

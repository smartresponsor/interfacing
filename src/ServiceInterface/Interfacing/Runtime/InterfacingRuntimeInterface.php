<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Runtime;

use App\Contract\ValueObject\ScreenId;

interface InterfacingRuntimeInterface
{
    public function resolveScreenComponentName(ScreenId $screenId): string;
}

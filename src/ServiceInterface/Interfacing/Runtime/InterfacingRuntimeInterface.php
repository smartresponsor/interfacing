<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Runtime;

use App\Interfacing\Contract\ValueObject\ScreenId;

interface InterfacingRuntimeInterface
{
    public function resolveScreenComponentName(ScreenId $screenId): string;
}

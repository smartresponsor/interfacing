<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Runtime;

use App\Interfacing\Contract\ValueObject\InterfaceScreenId;

interface InterfaceRuntimeInterface
{
    public function resolveScreenComponentName(InterfaceScreenId $screenId): string;
}

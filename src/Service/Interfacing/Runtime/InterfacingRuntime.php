<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Runtime;

use App\Contract\ValueObject\ScreenId;
use App\ServiceInterface\Interfacing\Runtime\InterfacingRuntimeInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;

final class InterfacingRuntime implements InterfacingRuntimeInterface
{
    public function __construct(private readonly ScreenRegistryInterface $screenRegistry)
    {
    }

    public function resolveScreenComponentName(ScreenId $screenId): string
    {
        return $this->screenRegistry->componentName($screenId);
    }
}

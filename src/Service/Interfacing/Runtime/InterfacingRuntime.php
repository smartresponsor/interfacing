<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Runtime;

use App\Interfacing\Contract\ValueObject\ScreenId;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\InterfacingRuntimeInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;

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

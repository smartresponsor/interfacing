<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Runtime;

use App\Interfacing\Contract\ValueObject\InterfaceScreenId;
use App\Interfacing\RegistryInterface\Runtime\InterfaceScreenRegistryInterface;
use App\Interfacing\ServiceInterface\Runtime\InterfaceRuntimeInterface;

final class InterfaceRuntimeService implements InterfaceRuntimeInterface
{
    public function __construct(private readonly InterfaceScreenRegistryInterface $screenRegistry)
    {
    }

    public function resolveScreenComponentName(InterfaceScreenId $screenId): string
    {
        return $this->screenRegistry->componentName($screenId);
    }
}

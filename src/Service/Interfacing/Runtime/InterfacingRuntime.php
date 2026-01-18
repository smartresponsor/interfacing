<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Runtime;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ScreenId;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\InterfacingRuntimeInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;

final class InterfacingRuntime implements InterfacingRuntimeInterface
{
    public function __construct(private ScreenRegistryInterface $screenRegistry)
    {
    }

    public function resolveScreenComponentName(ScreenId $screenId): string
    {
        return $this->screenRegistry->resolveComponentName($screenId);
    }
}

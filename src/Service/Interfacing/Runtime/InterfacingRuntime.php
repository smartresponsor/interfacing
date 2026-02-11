<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Runtime;

use App\Domain\Interfacing\Model\ScreenId;
use App\ServiceInterface\Interfacing\Runtime\InterfacingRuntimeInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;

/**
 *
 */

/**
 *
 */
final class InterfacingRuntime implements InterfacingRuntimeInterface
{
    /**
     * @param \App\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface $screenRegistry
     */
    public function __construct(private readonly ScreenRegistryInterface $screenRegistry)
    {
    }

    /**
     * @param \App\Domain\Interfacing\Model\ScreenId $screenId
     * @return string
     */
    public function resolveScreenComponentName(ScreenId $screenId): string
    {
        return $this->screenRegistry->resolveComponentName($screenId);
    }
}

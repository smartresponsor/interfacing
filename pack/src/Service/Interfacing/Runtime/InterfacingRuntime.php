<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Runtime;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\InterfacingRuntimeInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;

/**
 *
 */

/**
 *
 */
final readonly class InterfacingRuntime implements InterfacingRuntimeInterface
{
    /**
     * @param \SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface $screenRegistry
     */
    public function __construct(
        private ScreenRegistryInterface $screenRegistry,
    ) {
    }

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface $id
     * @return \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface
     */
    public function resolveScreen(ScreenIdInterface $id): ScreenSpecInterface
    {
        return $this->screenRegistry->get($id);
    }
}

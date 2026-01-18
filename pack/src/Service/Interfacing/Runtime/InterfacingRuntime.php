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

final class InterfacingRuntime implements InterfacingRuntimeInterface
{
    public function __construct(
        private readonly ScreenRegistryInterface $screenRegistry,
    ) {
    }

    public function resolveScreen(ScreenIdInterface $id): ScreenSpecInterface
    {
        return $this->screenRegistry->get($id);
    }
}

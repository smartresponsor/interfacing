<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

interface InterfacingRuntimeInterface
{
    public function resolveScreen(ScreenIdInterface $id): ScreenSpecInterface;
}

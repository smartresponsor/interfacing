<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\ServiceInterface\Interfacing\Runtime;

use App\DomainInterface\Interfacing\Model\ScreenIdInterface;
use App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

interface InterfacingRuntimeInterface
{
    public function resolveScreen(ScreenIdInterface $id): ScreenSpecInterface;
}

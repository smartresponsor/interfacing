<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ScreenId;

interface InterfacingRuntimeInterface
{
    public function resolveScreenComponentName(ScreenId $screenId): string;
}

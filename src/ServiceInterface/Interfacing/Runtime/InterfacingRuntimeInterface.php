<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Runtime;

use App\Domain\Interfacing\Model\ScreenId;

interface InterfacingRuntimeInterface
{
    public function resolveScreenComponentName(ScreenId $screenId): string;
}

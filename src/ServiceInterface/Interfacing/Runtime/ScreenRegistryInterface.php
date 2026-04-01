<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\ServiceInterface\Interfacing\Runtime;

use App\Contract\ValueObject\ScreenId;

interface ScreenRegistryInterface
{
    public function has(ScreenId $id): bool;

    public function componentName(ScreenId $id): string;
}

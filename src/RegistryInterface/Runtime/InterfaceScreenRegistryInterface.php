<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\RegistryInterface\Runtime;

use App\Interfacing\Contract\ValueObject\InterfaceScreenId;

interface InterfaceScreenRegistryInterface
{
    public function has(InterfaceScreenId $id): bool;

    public function componentName(InterfaceScreenId $id): string;
}

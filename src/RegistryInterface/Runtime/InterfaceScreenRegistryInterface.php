<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\RegistryInterface\Runtime;

use App\Interfacing\Contract\ValueObject\InterfaceScreenIdInterface;

interface InterfaceScreenRegistryInterface
{
    public function has(InterfaceScreenIdInterface $id): bool;

    public function componentName(InterfaceScreenIdInterface $id): string;
}

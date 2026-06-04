<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\AssemblerInterface\Runtime;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpecInterface;

interface InterfaceScreenContextAssemblerInterface
{
    /**
     * @return array<string,mixed>
     */
    public function contextFor(InterfaceLayoutScreenSpecInterface $spec): array;
}

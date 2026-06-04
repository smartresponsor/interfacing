<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Layout;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;

interface InterfaceLayoutShellInterface
{
    /**
     * @return array<string,mixed>
     */
    public function build(InterfaceLayoutScreenSpec $activeSpec, array $allSpec): array;
}

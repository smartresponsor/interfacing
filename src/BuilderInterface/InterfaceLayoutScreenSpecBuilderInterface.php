<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\BuilderInterface;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;

interface InterfaceLayoutScreenSpecBuilderInterface
{
    public function build(): InterfaceLayoutScreenSpec;
}

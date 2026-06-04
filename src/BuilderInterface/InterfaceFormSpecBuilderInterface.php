<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\BuilderInterface;

use App\Interfacing\Contract\Spec\InterfaceFormSpec;

interface InterfaceFormSpecBuilderInterface
{
    public function build(): InterfaceFormSpec;
}

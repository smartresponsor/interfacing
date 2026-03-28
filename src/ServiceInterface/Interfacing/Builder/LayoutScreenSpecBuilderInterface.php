<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\ServiceInterface\Interfacing\Builder;

use App\Contract\View\LayoutScreenSpec;

interface LayoutScreenSpecBuilderInterface
{
    public function build(): LayoutScreenSpec;
}

<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\ServiceInterface\Interfacing\Builder;

use App\Interfacing\Contract\Spec\MetricSpec;

interface MetricSpecBuilderInterface
{
    public function build(): MetricSpec;
}

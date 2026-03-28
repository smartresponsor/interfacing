<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\ServiceInterface\Interfacing\Builder;

use App\Contract\Spec\FormSpec;

interface FormSpecBuilderInterface
{
    public function build(): FormSpec;
}

<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing\View;

interface ScreenViewBuilderInterface
{
    /** @return array{spec:mixed,component:string,context:mixed,title:string} */
    public function build(string $layoutId): array;
}

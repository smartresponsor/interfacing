<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing\Screen;

interface ScreenHomeComponentInterface
{
    /**
     * @return array<array{slug:string,title:string}>
     */
    public function link(): array;
}

<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\LiveComponent\Screen;

interface InterfaceScreenHomeComponentInterface
{
    /**
     * @return array<array{slug:string,title:string}>
     */
    public function link(): array;
}

<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\ServiceInterface\Interfacing\View;

interface InterfacingIndexViewBuilderInterface
{
    /** @return array{screenList:list<array{id:string,title:string}>} */
    public function build(): array;
}

<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Runtime;

interface ScreenProviderInterface
{
    public function id(): string;

    /**
     * @return array<string,string> screenId => live component name
     */
    public function map(): array;
}

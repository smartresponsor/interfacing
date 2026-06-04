<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ProviderInterface\Runtime;

interface InterfaceBaseContextProviderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function context(): array;
}

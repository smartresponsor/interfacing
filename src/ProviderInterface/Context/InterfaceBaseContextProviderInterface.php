<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Context;

interface InterfaceBaseContextProviderInterface
{
    /** @return array<string, mixed> */
    public function provide(): array;
}

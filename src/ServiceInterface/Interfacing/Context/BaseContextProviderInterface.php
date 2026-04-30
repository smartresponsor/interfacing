<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Context;

interface BaseContextProviderInterface
{
    /** @return array<string, mixed> */
    public function provide(): array;
}

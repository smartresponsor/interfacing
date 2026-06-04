<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Action;

interface InterfaceActionResultInterface
{
    public function kind(): string;

    /** @return array<string, mixed> */
    public function payload(): array;
}

<?php

declare(strict_types=1);

namespace App\Contract\Action;

interface ActionResultInterface
{
    public function kind(): string;

    /** @return array<string, mixed> */
    public function payload(): array;
}

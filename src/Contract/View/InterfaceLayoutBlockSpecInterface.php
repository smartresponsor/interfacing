<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

interface InterfaceLayoutBlockSpecInterface
{
    public function type(): string;

    public function key(): string;

    /** @return array<string, mixed> */
    public function props(): array;
}

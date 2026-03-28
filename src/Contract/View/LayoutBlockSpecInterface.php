<?php

declare(strict_types=1);

namespace App\Contract\View;

interface LayoutBlockSpecInterface
{
    public function type(): string;

    public function key(): string;

    /** @return array<string, mixed> */
    public function props(): array;
}

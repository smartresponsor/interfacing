<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Contract\View;

final class DataGridRow
{
    public function __construct(private readonly string $id, private readonly array $cell)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function cell(): array
    {
        return $this->cell;
    }
}

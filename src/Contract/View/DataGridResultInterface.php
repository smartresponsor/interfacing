<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

interface DataGridResultInterface
{
    public function row(): array;

    public function page(): int;

    public function pageSize(): int;

    public function total(): int;

    public function hasPrev(): bool;

    public function hasNext(): bool;
}

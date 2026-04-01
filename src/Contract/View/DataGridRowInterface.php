<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Contract\View;

interface DataGridRowInterface
{
    public function id(): string;

    public function cell(): array;
}

<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

interface ShellViewInterface
{
    public function activeId(): ?string;

    public function query(): string;

    public function group(): array;

    public function itemTotal(): int;
}

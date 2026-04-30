<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

interface ShellNavItemInterface
{
    public function id(): string;

    public function title(): string;

    public function url(): string;

    public function group(): string;

    public function icon(): ?string;

    public function order(): int;
}

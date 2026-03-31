<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Contract\View;

interface FormFieldSpecInterface
{
    public function id(): string;

    public function title(): string;

    public function type(): string;

    public function required(): bool;

    public function placeholder(): string;

    public function option(): array;
}

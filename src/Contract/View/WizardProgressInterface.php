<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

interface WizardProgressInterface
{
    public function index(): int;

    public function total(): int;

    public function percent(): float;

    public function isFirst(): bool;

    public function isLast(): bool;
}

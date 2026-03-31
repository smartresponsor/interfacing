<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Contract\View;

interface MetricDatumInterface
{
    public function key(): string;

    public function title(): string;

    public function value(): float;

    public function unit(): string;

    public function delta(): ?float;
}

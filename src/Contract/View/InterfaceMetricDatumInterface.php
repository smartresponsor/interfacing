<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

interface InterfaceMetricDatumInterface
{
    public function key(): string;

    public function title(): string;

    public function value(): float;

    public function unit(): string;

    public function delta(): ?float;
}

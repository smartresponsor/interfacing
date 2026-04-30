<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\ServiceInterface\Interfacing\Metric;

interface UiMetricInterface
{
    public function inc(string $name, array $label = []): void;

    public function observeMs(string $name, float $ms, array $label = []): void;

    public function render(): string;
}

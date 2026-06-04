<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\MetricInterface;

interface InterfaceUiMetricInterface
{
    public function inc(string $name, array $label = []): void;

    public function observeMs(string $name, float $ms, array $label = []): void;

    public function render(): string;
}

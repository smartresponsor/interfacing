<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\MetricInterface;

interface InterfaceUiMetricInterface
{
    public function inc(string $nameEntity, array $label = []): void;

    public function observeMs(string $nameEntity, float $ms, array $label = []): void;

    public function render(): string;
}

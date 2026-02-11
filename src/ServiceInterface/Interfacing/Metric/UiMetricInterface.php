<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Metric;

/**
 *
 */

/**
 *
 */
interface UiMetricInterface
{
    /**
     * @param string $name
     * @param array $label
     * @return void
     */
    public function inc(string $name, array $label = []): void;

    /**
     * @param string $name
     * @param float $ms
     * @param array $label
     * @return void
     */
    public function observeMs(string $name, float $ms, array $label = []): void;

    /**
     * @return string
     */
    public function render(): string;
}

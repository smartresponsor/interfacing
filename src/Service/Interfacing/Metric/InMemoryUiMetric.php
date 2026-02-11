<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Service\Interfacing\Metric;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Metric\UiMetricInterface;

final class InMemoryUiMetric implements UiMetricInterface
{
    /** @var array<string,int> */
    private array $counter = [];

    /** @var array<string,float[]> */
    private array $sample = [];

    public function inc(string $name, array $label = []): void
    {
        $k = $this->key($name, $label);
        $this->counter[$k] = ($this->counter[$k] ?? 0) + 1;
    }

    public function observeMs(string $name, float $ms, array $label = []): void
    {
        $k = $this->key($name, $label);
        $this->sample[$k] ??= [];
        $this->sample[$k][] = $ms;
    }

    public function render(): string
    {
        $out = [];
        foreach ($this->counter as $k => $v) {
            $out[] = $this->line($k, (string)$v);
        }
        foreach ($this->sample as $k => $v) {
            $out[] = $this->line($k.'_count', (string)\count($v));
            $out[] = $this->line($k.'_sum_ms', (string)\array_sum($v));
        }
        return \implode("\n", $out)."\n";
    }

    private function key(string $name, array $label): string
    {
        if ($label === []) {
            return $name;
        }
        \ksort($label);
        $parts = [];
        foreach ($label as $k => $v) {
            $parts[] = $k.'="'.$this->esc((string)$v).'"';
        }
        return $name.'{'.\implode(',', $parts).'}';
    }

    private function line(string $k, string $v): string
    {
        return $k.' '.$v;
    }

    private function esc(string $v): string
    {
        return \str_replace(['\\', '"', "\n"], ['\\\\', '\"', ''], $v);
    }
}

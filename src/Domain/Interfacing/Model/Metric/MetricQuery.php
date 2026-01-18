<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Metric;

final class MetricQuery
{
    public function __construct(
        private string $range = '24h',
        private string $timezone = 'UTC',
    ) {
        $this->range = $this->normalizeRange($this->range);
        $this->timezone = trim($this->timezone) !== '' ? trim($this->timezone) : 'UTC';
    }

    public function range(): string
    {
        return $this->range;
    }

    public function timezone(): string
    {
        return $this->timezone;
    }

    private function normalizeRange(string $range): string
    {
        $range = strtolower(trim($range));
        $allow = ['15m', '1h', '6h', '24h', '7d', '30d'];
        if (in_array($range, $allow, true)) {
            return $range;
        }

        return '24h';
    }
}
